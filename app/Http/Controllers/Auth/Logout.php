<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Controller;

use Illuminate\Http\Request;

/**
 * Controller
 * 
 * @author Saka Mahendra Arioka
 *         saka@sakarioka.com
 *         +6285338845666
 */
class Logout extends Controller
{

  // method index (default)
  public function index(Request $request)
  {
    $request->session()->flush();

    return redirect(env('DOMAIN_USER_URL'))->with('__logout_success', 1);
  }
}
