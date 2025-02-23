<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Intervention\Image\Facades\Image;

class Controller extends BaseController
{

  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  protected $data = [];

  public function __construct()
  {
    $this->middleware(function ($request, $next) {
      $auth_data = session('auth_data');

      if (!empty($auth_data) && $request->segment(1) == 'login') {
        return redirect()->route('homeIndex');
      } elseif (empty($auth_data) && $request->segment(1) != 'login') {
        return redirect(env('DOMAIN_AUTH_LOGIN_URL'));
      }

      $this->data['auth_data']  = $auth_data;
      $this->data['errors']     = [];
      $this->data['upload_url'] = env('UPLOAD_URL');

      return $next($request);
    });
  }

  public function randomString($length = 10)
  {
    $characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';

    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
  }

  /**
   * Create a thumbnail of specified size
   *
   * @param string $path path of thumbnail
   * @param int $width
   * @param int $height
   */
  public function cropImage($path, $width, $height)
  {
    $img = Image::make(storage_path() . "/app/" . $path)->resize($width, $height);
    $img->save(storage_path() . "/app/" . $path);

    return ltrim($path, 'public');
  }
}
