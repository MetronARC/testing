<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\UserModel;

/**
 * Controller
 * 
 * @author Saka Mahendra Arioka
 *         saka@sakarioka.com
 *         +6285338845666
 */
class Login extends Controller
{

  // method index (default)
  public function index(Request $request)
  {
    $errors = '';

    if ($request->isMethod('post')) {
      $auth = UserModel::where('email', $request->post('email'))
        ->where('deleted_at', null)
        ->where('status', 1)
        ->first();

      if ($auth = $auth ? $auth->toArray() : []) {
        $password = $request->post('password');

        if (!empty($auth['temp_password']) && $auth['temp_password'] == $password && strtotime($auth['temp_password_expired_at']) > strtotime('now')) {
          $isLoginCorrect = true;
        } else {
          $isLoginCorrect = Hash::check($password . env('APP_TOKEN'), $auth['password']);
        }

        if ($isLoginCorrect) {
          UserModel::where('id', $auth['id'])
            ->where('email_verified_at', null)
            ->update(['email_verified_at' => date('Y-m-d H:i:s')]);

          UserModel::where('id', $auth['id'])
            ->update(['last_login_at' => date('Y-m-d H:i:s')]);

          $auth = UserModel::where('email', $request->post('email'))
            ->where('deleted_at', null)
            ->where('status', 1)
            ->first();

          $request->session()->put('auth_data', $auth);

          if ($_currentUrl = $request->input('current')) {
            return redirect($_currentUrl)->with('__login_success', 1);
          } elseif ($_currentUrl = $request->input('redirect')) {
            return redirect($_currentUrl)->with('__login_success', 1);
          } else {
            return redirect(env('DOMAIN_USER_URL'))->with('__login_success', 1);
          }
        }
      }

      $errors = 'Invalid email or password';
    }

    $this->data['errors'] = $errors;

    return view('auth/login.v_index', $this->data);
  }
}
