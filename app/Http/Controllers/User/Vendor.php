<?php

namespace App\Http\Controllers\User;

// use App\User;
use App\Http\Controllers\User\Controller;
use Illuminate\Http\Request;

use Yajra\DataTables\DataTables;

use App\Models\VendorModel;

class Vendor extends Controller
{

  public function index(Request $request, $lang = '')
  {
    $vendors = VendorModel::selectRaw("
      UPPER(name) name
    ")
      ->where('deleted_at', null)
      ->where('status', 'publish')
      ->orderBy('slug', 'ASC')
      ->get();

    $locations = VendorModel::selectRaw("
      UPPER(location) location
    ")
      ->where('deleted_at', null)
      ->where('status', 'publish')
      ->groupBy('location')
      ->orderBy('slug', 'ASC')
      ->get();

    $this->data['vendors']    = $vendors->toArray();
    $this->data['locations']  = $locations->toArray();

    return view('user.vendor.v_index', $this->data);
  }

  public function detail(Request $request, $id = '', $lang = '')
  {
    $vendor = VendorModel::where('vendors.deleted_at', null)
      ->where('vendors.id', $id)
      ->where('status', 'publish')
      ->first();

    $vendorBranchs = VendorModel::selectRaw("
        id,
        name,
        slug
    ")
      ->where('deleted_at', null)
      ->whereIn('id', explode(', ', $vendor['branch']))
      ->where('status', 'publish')
      ->get();

    $this->data['vendor']        = $vendor;
    $this->data['vendorBranchs'] = $vendorBranchs;

    return view('user.vendor.v_detail', $this->data);
  }

  public function datatable(Request $request, $lang = '')
  {
    $vendors = VendorModel::selectRaw("
      id,
      type,
      UPPER(name) name,
      slug,
      UPPER(location) location
    ")
      ->where('deleted_at', null)
      ->where('status', 'publish')
      ->orderBy('slug', 'ASC')
      ->get();

    return Datatables::of($vendors)->make();
  }
}
