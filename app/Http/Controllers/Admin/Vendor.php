<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

use App\Models\VendorModel;

use Yajra\DataTables\DataTables;

/**
 * Controller
 * 
 * @author Saka Mahendra Arioka
 *         saka@sakarioka.com
 *         +6285338845666
 */
class Vendor extends Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['title'] = 'Vendor';
  }

  // method index (default)
  public function index(Request $request)
  {
    // check authentication
    $this->_checkAuth();

    // set view
    return view('admin/vendor.v_index', $this->data);
  }

  public function datatable(Request $request)
  {
    // check authentication
    $this->_checkAuth();

    $vendors = VendorModel::selectRaw("
      vendors.id,
      vendors.type,
      vendors.name,
      vendors.slug,
      vendors.location,
      vendors.status
    ")
      ->where('vendors.deleted_at', null)
      ->orderBy('vendors.slug', 'ASC');

    if ($this->data['auth_data']['role'] == 'vendor') {
      $vendors->join('user_vendors', function ($join) {
        $join->on('user_vendors.vendor_id', '=', 'vendors.id');
        $join->where('user_vendors.user_id', $this->data['auth_data']['id']);
        $join->where('user_vendors.deleted_at', null);
      });
    }

    $vendors = $vendors->get();

    return Datatables::of($vendors)->make();
  }

  public function add(Request $request)
  {
    // check authentication
    $this->_checkAuth();

    $this->data['title'] .= ' Add New';

    $mVendor = new VendorModel();

    if ($request->post()) {
      $_type = $request->post('type');
      $_name = $request->post('name');
      $_slug = Str::slug(trim($_type . ' ' . $_name));

      $_location = $request->post('location');

      $inputData = [
        'type'           => $_type,
        'name'           => $_name,
        'location'       => $_location,
      ];

      $errors = $mVendor->validate($inputData);

      if (empty($errors) && $request->post('is_submit')) {
        $addressLocations = [];
        $contacts         = [];
        $videos           = [];

        $addressLocationAddress = $request->post('address_location_address');
        $addressLocationPhone   = $request->post('address_location_phone');
        $contactName            = $request->post('contact_name');
        $contactPosition        = $request->post('contact_position');
        $contactPhone           = $request->post('contact_phone');
        $contactEmail           = $request->post('contact_email');
        $videoUrl               = $request->post('video_url');

        if (!empty($addressLocationAddress)) {
          foreach ($addressLocationAddress as $_key => $_val) {
            if (!empty($_val)) {
              $addressLocations[] = [
                'address' => $_val,
                'phone'   => $addressLocationPhone[$_key]
              ];
            }
          }
        }

        if (!empty($contactName)) {
          foreach ($contactName as $_key => $_val) {
            if (!empty($_val)) {
              $contacts[] = [
                'name'     => $_val,
                'position' => $contactPosition[$_key],
                'phone'    => $contactPhone[$_key],
                'email'    => $contactEmail[$_key]
              ];
            }
          }
        }

        if (!empty($videoUrl)) {
          foreach ($videoUrl as $_key => $_val) {
            if (!empty($_val) && !empty($videoUrl[$_key])) {
              $videos[] = extractVideoID($_val);
            }
          }
        }

        $longitude = $request->post('longitude');
        $latitude = $request->post('latitude');

        $latitude = (!empty($latitude) || $latitude === '0') ? doubleval($latitude) : null;
        $longitude = (!empty($longitude) || $longitude === '0') ? doubleval($longitude) : null;

        $inputData = array_merge($inputData, [
          'slug'             => $_slug,
          'listing_number'   => $request->post('listing_number'),
          'address_location' => json_encode($addressLocations),
          'website_url'      => $request->post('website_url'),
          'latitude'         => $latitude,
          'longitude'        => $longitude,
          'established_year' => $request->post('established_year'),
          'group'            => $request->post('group'),
          'contact'          => json_encode($contacts),
          'certificate'      => $request->post('certificate'),
          'service'          => $request->post('service'),
          'video'            => json_encode($videos),
          'status'           => $request->post('status'),
          'created_by'       => $this->data['auth_data']['id'],
          'updated_by'       => $this->data['auth_data']['id'],
        ]);

        try {
          DB::beginTransaction();

          if (!empty($request->file('logo'))) {
            $inputData['logo'] = $request->file('logo')->store('upload/vendor/' . date('Y') . '/' . date('m'));
          } else {
            $inputData['logo'] = null;
          }

          if (!empty($request->file('image'))) {
            foreach ($request->file('image') as $image) {
              // Store each image in a unique directory
              $inputData['image'][] = $image->store('upload/shipyard_image/' . date('Y') . '/' . date('m'));
            }
          }

          if (!empty($inputData['image'])) {
            $inputData['image'] = json_encode($inputData['image']);
          } else {
            $inputData['image'] = json_encode([]);
          }

          // Perform your database operations using Eloquent here
          VendorModel::create($inputData);

          // Commit the transaction
          DB::commit();
        } catch (\Exception $e) {
          dd($e);
          // If an exception occurs, rollback the transaction
          DB::rollback();
        }

        return redirect()->route('vendor.vendorIndex')->with('__success', 'Data Added.');
      } else {
        return response()->json($errors);
      }

      $this->data['errors'] = $errors;
    }

    $vendors = VendorModel::selectRaw("
      id,
      type,
      name
    ")
      ->where('deleted_at', null)
      ->orderBy('slug', 'ASC')
      ->get();

    $vendorLocations  = $mVendor->getLocations();

    if (!empty($_location)) {
      $vendorLocations = array_unique(array_merge($vendorLocations, [$_location]));
    }

    $this->data['vendors']          = $vendors->toArray();
    $this->data['vendorLocations']  = $vendorLocations;

    return view('admin/vendor.v_add', $this->data);
  }

  public function detail(Request $request, $id)
  {
    // check authentication
    $this->_checkAuth();

    $this->data['title'] .= ' Detail';

    $mVendor = new VendorModel();

    $vendor = VendorModel::where('vendors.deleted_at', null)
      ->where('vendors.id', $id);

    if ($this->data['auth_data']['role'] == 'vendor') {
      $vendor->join('user_vendors', function ($join) {
        $join->on('user_vendors.vendor_id', '=', 'vendors.id');
        $join->where('user_vendors.user_id', $this->data['auth_data']['id']);
        $join->where('user_vendors.deleted_at', null);
      });
    }

    $vendor = $vendor->first();

    if (empty($vendor)) {
      abort(404);
    }

    $vendor = $vendor->toArray();

    if ($request->post()) {
      $_type = $request->post('type');
      $_name = $request->post('name');
      $_slug = Str::slug(trim($_type . ' ' . $_name));

      $_location = $request->post('location');

      $inputData = [
        'type'           => $_type,
        'name'           => $_name,
        'location'       => $_location,
      ];

      $errors = $mVendor->validate($inputData);

      if (empty($errors) && $request->post('is_submit')) {
        $addressLocations = [];
        $contacts         = [];
        $videos           = [];

        $addressLocationAddress = $request->post('address_location_address');
        $addressLocationPhone   = $request->post('address_location_phone');
        $contactName            = $request->post('contact_name');
        $contactPosition        = $request->post('contact_position');
        $contactPhone           = $request->post('contact_phone');
        $contactEmail           = $request->post('contact_email');
        $videoUrl               = $request->post('video_url');

        if (!empty($addressLocationAddress)) {
          foreach ($addressLocationAddress as $_key => $_val) {
            if (!empty($_val)) {
              $addressLocations[] = [
                'address' => $_val,
                'phone'   => $addressLocationPhone[$_key]
              ];
            }
          }
        }

        if (!empty($contactName)) {
          foreach ($contactName as $_key => $_val) {
            if (!empty($_val)) {
              $contacts[] = [
                'name'     => $_val,
                'position' => $contactPosition[$_key],
                'phone'    => $contactPhone[$_key],
                'email'    => $contactEmail[$_key]
              ];
            }
          }
        }

        if (!empty($videoUrl)) {
          foreach ($videoUrl as $_key => $_val) {
            if (!empty($_val) && !empty($videoUrl[$_key])) {
              $videos[] = extractVideoID($_val);
            }
          }
        }

        $longitude = $request->post('longitude');
        $latitude = $request->post('latitude');

        $latitude = (!empty($latitude) || $latitude === '0') ? doubleval($latitude) : null;
        $longitude = (!empty($longitude) || $longitude === '0') ? doubleval($longitude) : null;

        $inputData = array_merge($inputData, [
          'slug'             => $_slug,
          'listing_number'   => $request->post('listing_number'),
          'address_location' => json_encode($addressLocations),
          'website_url'      => $request->post('website_url'),
          'latitude'         => $latitude,
          'longitude'        => $longitude,
          'established_year' => $request->post('established_year'),
          'group'            => $request->post('group'),
          'contact'          => json_encode($contacts),
          'certificate'      => $request->post('certificate'),
          'service'          => $request->post('service'),
          'video'            => json_encode($videos),
          'status'           => $request->post('status'),
          'created_by'       => $this->data['auth_data']['id'],
          'updated_by'       => $this->data['auth_data']['id'],
        ]);

        try {
          DB::beginTransaction();

          if (!empty($request->file('logo'))) {
            $inputData['logo'] = $request->file('logo')->store('upload/vendor/' . date('Y') . '/' . date('m'));
          } else {
            $inputData['logo'] = $vendor['logo'];
          }

          if ($request->post('image_filename')) {
            foreach ($request->post('image_filename') as $key => $val) {
              if (!empty($val)) {
                $inputData['image'][$key] = $val;
              }
            }
          }

          if ($request->file('image')) {
            foreach ($request->file('image') as $key => $image) {
              if ($image->isValid()) {
                // Store each image in a unique directory
                $inputData['image'][$key] = $image->store('upload/shipyard_image/' . date('Y') . '/' . date('m'));
              } else {
                // Log or handle the invalid file.
                // You can get more details about the error with $image->getErrorMessage()
                return redirect()->route('shipyard.shipyardIndex')->with('__error', $image->getErrorMessage());
              }
            }
          }

          if (!empty($inputData['image'])) {
            $inputData['image'] = json_encode($inputData['image']);
          } else {
            $inputData['image'] = json_encode([]);
          }

          // Perform your database operations using Eloquent here
          VendorModel::where([
            'id' => $id
          ])->update($inputData);

          // Commit the transaction
          DB::commit();
        } catch (\Exception $e) {
          dd($e);
          // If an exception occurs, rollback the transaction
          DB::rollback();
        }

        return redirect()->route('vendor.vendorIndex')->with('__success', 'Data Updated.');
      } else {
        // dd($request->post());
        return response()->json($errors);
      }

      $this->data['errors'] = $errors;
    }

    $vendors = VendorModel::selectRaw("
      id,
      type,
      name
    ")
      ->where('deleted_at', null)
      ->where('id', '!=', $id)
      ->orderBy('slug', 'ASC')
      ->get();

    $vendorLocations  = $mVendor->getLocations();

    if (!empty($_location)) {
      $vendorLocations = array_unique(array_merge($vendorLocations, [$_location]));
    }

    $this->data['vendor']           = $vendor->toArray();
    $this->data['vendors']          = $vendors->toArray();
    $this->data['vendorLocations']  = $vendorLocations;

    return view('admin/vendor.v_detail', $this->data);
  }

  public function delete(Request $request, $id)
  {
    // check authentication
    $this->_checkAuth();

    VendorModel::where([
      'id' => $id
    ])->update([
      'deleted_at' => date('Y-m-d H:i:s'),
      'deleted_by' => $this->data['auth_data']['id'],
    ]);

    return redirect()->route('vendor.vendorIndex')->with('__status', 'Data Deleted.');
  }

  protected function _checkAuth()
  {
    if (!in_array($this->data['auth_data']['role'], ['admin', 'superadmin', 'vendor'])) {
      abort(404);
    }
  }
}
