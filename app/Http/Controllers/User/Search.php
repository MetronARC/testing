<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\User\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Yajra\DataTables\DataTables;

use App\Models\ShipyardModel;
use App\Models\VendorModel;
use App\Models\JobModel;

class Search extends Controller
{

  public function index(Request $request, $lang = '')
  {
    $searchData = [];

    $keyword = $request->get('s');

    $shipyards = ShipyardModel::selectRaw("
      id,
      UPPER(CONCAT(UPPER(type), ' ', name)) name,
      slug
      ")
      ->where('name', 'like', '%' . $keyword . '%')
      ->where('deleted_at', null)
      ->get()
      ->toArray();

    $vendors = VendorModel::selectRaw("
        id,
        UPPER(CONCAT(UPPER(type), ' ', name)) name,
        slug
      ")
      ->where('name', 'like', '%' . $keyword . '%')
      ->where('deleted_at', null)
      ->get()
      ->toArray();

    $jobs = JobModel::selectRaw("
      id,
      UPPER(company) company,
      UPPER(position) position,
      status,
      posted_start_at,
      posted_end_at
    ")
      ->whereRaw("CONCAT(position, ' ', company) like '%{$keyword}%'")
      ->where('deleted_at', null)
      ->where('status', 'publish')
      ->whereRaw('(posted_start_at IS NULL OR posted_start_at <= now())')
      ->whereRaw('(posted_end_at IS NULL OR posted_end_at >= now())')
      ->get()
      ->toArray();

    $this->data['shipyards'] = $shipyards;
    $this->data['vendors'] = $vendors;
    $this->data['jobs'] = $jobs;

    return view('user.search.v_index', $this->data);
  }
}
