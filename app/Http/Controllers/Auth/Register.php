<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Mail\RegistrationEmail;
use Illuminate\Support\Facades\Mail;

use App\Models\UserModel;
use App\Models\UserShipyardModel;
use App\Models\ShipyardModel;
use App\Models\RegisterCategoryModel;

/**
 * Controller
 * 
 * @author Saka Mahendra Arioka
 *         saka@sakarioka.com
 *         +6285338845666
 */
class Register extends Controller
{

  // method index (default)
  public function index(Request $request)
  {
    $registerCategories = RegisterCategoryModel::where('deleted_at', null)
      ->orderBy('order_number', 'ASC')
      ->get()
      ->toArray();

    $regCatArr = [];

    foreach ($registerCategories as $_val) {
      $regCatArr[$_val['category']][] = $_val;
    }

    $this->data['registerCategories'] = $regCatArr;

    return view('auth/register.v_index', $this->data);
  }

  public function category(Request $request, $category, $type)
  {
    $errors = '';

    if (!in_array($category, ['shipyard', 'marine-vendor', 'ship-owner-ship-manager'])) {
      abort(404);
    }

    if (!in_array($type, ['free', 'pro'])) {
      abort(404);
    }

    if ($data = $request->post()) {
      $shipyard_id  = $request->post('shipyard_id');
      $company_name = $request->post('company_name');
      $name         = $request->post('name');
      $position     = $request->post('position');
      $phone        = $request->post('phone');
      $email        = $request->post('email');

      $inputData = [
        'shipyard_id'  => $shipyard_id,
        'company_name' => $company_name,
        'name'         => $name,
        'position'     => $position,
        'phone'        => $phone,
        'email'        => $email,
        'category'     => $category,
        'type'         => $type,
        'token'        => Str::random(40)
      ];

      $mUser = new UserModel();

      $errors = $mUser->validateRegister($inputData);

      if (empty($errors)) {
        unset($inputData['shipyard_id']);
        unset($inputData['category']);
        unset($inputData['type']);

        switch ($category) {
          case 'shipyard':
            $inputData['role'] = 'shipyard';
            break;
          case 'marine-vendor':
            $inputData['role'] = 'vendor';
            break;
          case 'ship-owner-ship-manager':
            $inputData['role'] = 'ship_manager';
            break;
        }

        switch ($type) {
          case 'free':
            $inputData['member_type'] = 'basic';
            break;
          case 'pro':
            $inputData['member_type'] = 'premium';
            break;
        }

        DB::beginTransaction();

        try {
          // Perform your database operations here
          $result = UserModel::create($inputData);

          switch ($category) {
            case 'shipyard':
              UserShipyardModel::create([
                'user_id'     => $result->id,
                'shipyard_id' => $shipyard_id
              ]);

              break;
          }

          $user = UserModel::where('users.id', $result->id)
            ->where('users.deleted_at', null)
            ->where('users.status', 0)
            ->where('users.mail_register_send_at', null)
            ->first();

          $eRegistration = new RegistrationEmail($user);

          Mail::send($eRegistration);

          if (count(Mail::failures()) == 0) {
            UserModel::where('id', $user->id)->update(['mail_register_send_at' => DB::raw('NOW()')]);
          }

          // If everything is successful, commit the transaction
          DB::commit();

          return redirect()->route('registerFinish', [
            'email' => $user->email,
            'token' => $user->token
          ]);
        } catch (\Exception $e) {
          // Something went wrong, so roll back the transaction
          DB::rollback();
        }
      }

      $this->data['errors'] = $errors;
    }

    switch ($category) {
      case 'shipyard':
        $categoryName = 'SHIPYARD';

        $this->data['shipyards'] = ShipyardModel::where('deleted_at', null)
          ->where('status', 'publish')
          ->orderBy('slug', 'ASC')
          ->get()
          ->toArray();

        break;
      case 'marine-vendor':
        $categoryName = 'MARINE VENDOR';
        break;
      case 'ship-owner-ship-manager':
        $categoryName = 'SHIP OWNER / SHIP MANAGER';
        break;
    }

    $this->data['category']     = $category;
    $this->data['type']         = $type;
    $this->data['categoryName'] = $categoryName;
    $this->data['errors']       = $errors;

    return view('auth/register.v_category', $this->data);
  }

  public function finish(Request $request)
  {
    $user = UserModel::where('email', $request->post('email'))
      ->where('token', $request->post('token'))
      ->where('deleted_at', null)
      ->first();

    if (empty($user)) {
      abort(404);
    }

    $this->data['user'] = $user;

    return view('auth/register.v_finish', $this->data);
  }
}
