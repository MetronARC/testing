<?php

namespace App\Http\Controllers\User;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{

  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

  protected $data   = [];
  protected $errors = [];

  public function __construct()
  {
    $this->middleware(function ($request, $next) {
      $current_lang = session('current_lang');
      $auth_data    = session('auth_data');

      if (!$current_lang) {
        $current_lang = 'en';
      }

      $menuArr = [
        'SHIPYARD'      => route('shipyard.shipyardIndex'),
        'MARINE VENDOR' => route('vendor.vendorIndex'),
        'TENDER'        => route('tender.tenderIndex'),
        'FOR SALE'      => route('sale.saleIndex'),
        'NEWS'          => route('news.newsIndex'),
        'JOB VACANCY'   => route('job.jobIndex'),
      ];

      $this->data['auth_data']       = $auth_data;
      $this->data['current_lang']    = $current_lang;
      $this->data['metaTitle']       = 'Dockyard ID';
      $this->data['metaDescription'] = '';
      $this->data['menuArr']         = $menuArr;
      $this->data['errors']          = [];

      return $next($request);
    });
  }
}
