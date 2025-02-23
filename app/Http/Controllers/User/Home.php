<?php

namespace App\Http\Controllers\User;

// use App\User;
use App\Http\Controllers\User\Controller;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

use App\Models\BannerModel;
use App\Models\InvoiceModel;
use App\Models\ConcertModel;

class Home extends Controller
{
  public function index(Request $request, $lang = '')
  {
    return view('user.home.v_index', $this->data);
  }
}
