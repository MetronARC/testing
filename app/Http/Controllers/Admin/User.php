<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;

use App\Mail\ChangePasswordEmail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;

use App\Models\UserModel;

use Yajra\DataTables\DataTables;

/**
 * Controller
 * 
 * @author Saka Mahendra Arioka
 *         saka@sakarioka.com
 *         +6285338845666
 */
class User extends Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['title'] = 'User';
  }

  // method index (default)
  public function index(Request $request)
  {
    // set view
    return view('admin/user.v_index', $this->data);
  }

  public function datatable(Request $request)
  {
    $users = UserModel::selectRaw("
      users.id,
      UPPER(users.name) name,
      CASE 
        WHEN users.role = 'shipyard' THEN 'SHIPYARD'
        WHEN users.role = 'vendor' THEN 'MARINE VENDOR'
        WHEN users.role = 'ship_manager' THEN 'SHIP MANAGER'
      END role,
      CASE
        WHEN users.member_type = 'premium' THEN 'PRO MEMBERSHIP'
        ELSE 'FREE MEMBERSHIP'
      END member_type,
      UPPER(users.company_name) company,
      GROUP_CONCAT(shipyards.name ORDER BY shipyards.name SEPARATOR ', ') AS shipyard,
      UPPER(users.position) position,
      UPPER(users.phone) phone,
      UPPER(users.email) email,
      CASE
        WHEN users.status = 1 THEN 'VERIFIED'
        ELSE 'NOTVERIFIED'
      END status
    ")
      ->leftJoin('user_shipyards', function ($join) {
        $join->on('user_shipyards.user_id', '=', 'users.id');
        $join->where('user_shipyards.deleted_at', null);
      })
      ->leftJoin('shipyards', function ($join) {
        $join->on('shipyards.id', '=', 'user_shipyards.shipyard_id');
        $join->where('shipyards.deleted_at', null);
      })
      ->where('users.deleted_at', null)
      ->whereIn('users.role', ['shipyard', 'vendor', 'ship_manager'])
      ->orderBy('users.name', 'ASC')
      ->groupBy('users.id')
      ->get();

    // dd($users);

    return Datatables::of($users)
      ->rawColumns(['shipyard_company', 'business_type', 'user_detail'])
      ->make();
  }

  public function verify(Request $request)
  {
    $id = $request->post('user_id');

    UserModel::where('id', $id)
      ->update([
        'status'                   => 1,
        'verified_at'              => date('Y-m-d H:i:s'),
        'temp_password'            => Str::random(5),
        'temp_password_expired_at' => date('Y-m-d H:i:s', strtotime('+30 day'))
      ]);

    return redirect()->back()->with('__success', 'User verified. Temporary password will be sent to User email.');
  }

  public function changePassword(Request $request)
  {
    if ($request->post()) {
      $currentPassword    = $request->post('current_password');
      $newPassword        = $request->post('new_password');
      $reinputNewPassword = $request->post('reinput_new_password');

      $errors = [];

      if (empty($currentPassword)) {
        $errors['current_password'] = 'This field is required.';
      } else {
        if (!empty($this->data['auth_data']['temp_password']) && strtotime($this->data['auth_data']['temp_password_expired_at']) > strtotime('now')) {
          if ($this->data['auth_data']['temp_password'] != $currentPassword) {
            $errors['current_password'] = 'Current password is incorrect.';
          }
        } else {
          if (!Hash::check($currentPassword . env('APP_TOKEN'), $this->data['auth_data']['password'])) {
            $errors['current_password'] = 'Current password is incorrect.';
          }
        }
      }

      if (empty($newPassword)) {
        $errors['new_password'] = 'This field is required.';
      } elseif ($newPassword != $reinputNewPassword) {
        $errors['new_password'] = 'New password is not same with re-input new password';
      }

      if (empty($reinputNewPassword)) {
        $errors['reinput_new_password'] = 'This field is required.';
      }

      if (empty($errors)) {
        UserModel::where('id', $this->data['auth_data']['id'])
          ->update([
            'password'                 => Hash::make($newPassword),
            'temp_password'            => null,
            'temp_password_expired_at' => null,
          ]);

        $auth = UserModel::where('id', $this->data['auth_data']['id'])
          ->where('deleted_at', null)
          ->where('status', 1)
          ->first();

        $request->session()->put('auth_data', $auth);

        $eChangePassword = new ChangePasswordEmail($auth);

        Mail::send($eChangePassword);

        return redirect()->route('homeIndex')->with('__success', 'Password updated.');
      }

      $this->data['errors'] = $errors;
    }

    // set view
    return view('admin/user.v_change_password', $this->data);
  }
}
