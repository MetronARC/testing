<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\ShipyardCategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

use App\Models\ShipyardModel;
use App\Models\UserShipyardModel;

use Yajra\DataTables\DataTables;

/**
 * Controller
 * 
 * @author Saka Mahendra Arioka
 *         saka@sakarioka.com
 *         +6285338845666
 */
class Shipyard extends Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['title'] = 'Shipyard';
  }

  // method index (default)
  public function index(Request $request)
  {
    // check authentication
    $this->_checkAuth();

    // set view
    return view('admin/shipyard.v_index', $this->data);
  }

  public function datatable(Request $request)
  {
    // check authentication
    $this->_checkAuth();

    $shipyards = ShipyardModel::selectRaw("
      shipyards.id,
      shipyards.type,
      shipyards.name,
      shipyards.slug,
      shipyards.location,
      shipyards.category,
      shipyards.status
    ")
      ->where('shipyards.deleted_at', null)
      ->orderBy('shipyards.slug', 'ASC');

    if ($this->data['auth_data']['role'] == 'shipyard') {
      $shipyards->join('user_shipyards', function ($join) {
        $join->on('user_shipyards.shipyard_id', '=', 'shipyards.id');
        $join->where('user_shipyards.user_id', $this->data['auth_data']['id']);
        $join->where('user_shipyards.deleted_at', null);
      });
    }

    $shipyards = $shipyards->get();

    return Datatables::of($shipyards)->make();
  }

  public function add(Request $request)
  {
    // check authentication
    $this->_checkAuth();

    $this->data['title'] .= ' Add New';

    $mShipyard         = new ShipyardModel();
    $mShipyardCategory = new ShipyardCategoryModel();

    if ($request->post()) {
      $_type = $request->post('type');
      $_name = $request->post('name');
      $_slug = Str::slug(trim($_type . ' ' . $_name));

      $_location = $request->post('location');
      $_category = $request->post('category');
      $_branch   = $request->post('branch');

      $inputData = [
        'type'           => $_type,
        'name'           => $_name,
        'location'       => $_location,
        'category'       => $_category ? implode(', ', $_category) : null,
      ];

      $errors = $mShipyard->validate($inputData);

      if (empty($errors) && $request->post('is_submit')) {
        // dd($request->posts());

        $yards         = [];
        $contacts      = [];
        $gravingDocks  = [];
        $floatingDocks = [];
        $shipRepairs   = [];
        $newBuildings  = [];
        $videos        = [];

        $yardAddress         = $request->post('yard_address');
        $yardPhone           = $request->post('yard_phone');
        $contactName         = $request->post('contact_name');
        $contactPosition     = $request->post('contact_position');
        $contactPhone        = $request->post('contact_phone');
        $contactEmail        = $request->post('contact_email');
        $gravingDockLabel    = $request->post('graving_dock_label');
        $gravingDockValue    = $request->post('graving_dock_value');
        $floatingDockLabel   = $request->post('floating_dock_label');
        $floatingDockValue   = $request->post('floating_dock_value');
        $shipRepairHull      = $request->post('ship_repair_hull');
        $shipRepairOwner     = $request->post('ship_repair_owner');
        $shipRepairType      = $request->post('ship_repair_type');
        $shipRepairDimension = $request->post('ship_repair_dimension');
        $shipRepairDate      = $request->post('ship_repair_date');
        $newBuildingShipName = $request->post('new_building_ship_name');
        $newBuildingShipType = $request->post('new_building_ship_type');
        $newBuildingOwner    = $request->post('new_building_owner');
        $newBuildingDate     = $request->post('new_building_date');
        $newBuildingWorkType = $request->post('new_building_work_type');
        $videoUrl            = $request->post('video_url');

        // dd($yardAddress);

        if (!empty($yardAddress)) {
          foreach ($yardAddress as $_key => $_val) {
            if (!empty($_val) && !empty($yardPhone[$_key])) {
              $yards[] = [
                'address' => $_val,
                'phone'   => $yardPhone[$_key]
              ];
            }
          }
        }

        if (!empty($contactName)) {
          foreach ($contactName as $_key => $_val) {
            if (!empty($_val) && !empty($contactName[$_key])) {
              $contacts[] = [
                'name'     => $_val,
                'position' => $contactPosition[$_key],
                'phone'    => $contactPhone[$_key],
                'email'    => $contactEmail[$_key]
              ];
            }
          }
        }

        if (!empty($gravingDockLabel)) {
          foreach ($gravingDockLabel as $_key => $_val) {
            if (!empty($_val) && !empty($gravingDockValue[$_key])) {
              $gravingDocks[] = [
                'label' => $_val,
                'value' => $gravingDockValue[$_key]
              ];
            }
          }
        }

        if (!empty($floatingDockLabel)) {
          foreach ($floatingDockLabel as $_key => $_val) {
            if (!empty($_val) && !empty($floatingDockValue[$_key])) {
              $floatingDocks[] = [
                'label' => $_val,
                'value' => $floatingDockValue[$_key]
              ];
            }
          }
        }

        if (!empty($shipRepairHull)) {
          foreach ($shipRepairHull as $_key => $_val) {
            if (!empty($_val) && !empty($shipRepairHull[$_key])) {
              $shipRepairs[] = [
                'hull'      => $_val,
                'owner'     => $shipRepairOwner[$_key],
                'type'      => $shipRepairType[$_key],
                'dimension' => $shipRepairDimension[$_key],
                'date'      => $shipRepairDate[$_key]
              ];
            }
          }
        }

        if (!empty($newBuildingShipName)) {
          foreach ($newBuildingShipName as $_key => $_val) {
            if (!empty($_val) && !empty($newBuildingShipName[$_key])) {
              $newBuildings[] = [
                'ship_name' => $_val,
                'ship_type' => $newBuildingShipType[$_key],
                'owner'     => $newBuildingOwner[$_key],
                'date'      => $newBuildingDate[$_key],
                'work_type' => $newBuildingWorkType[$_key]
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

        $service = [
          'ship_repair'   => $request->post('service_shiprepair') ? 1 : 0,
          'ship_building' => $request->post('service_building') ? 1 : 0
        ];

        $construction = [
          'steel'     => $request->post('construction_steel') ? 1 : 0,
          'aluminium' => $request->post('construction_aluminium') ? 1 : 0,
          'other'     => $request->post('construction_other') ? 1 : 0
        ];

        $longitude = $request->post('longitude');
        $latitude = $request->post('latitude');

        $latitude = (!empty($latitude) || $latitude === '0') ? doubleval($latitude) : null;
        $longitude = (!empty($longitude) || $longitude === '0') ? doubleval($longitude) : null;

        $inputData = array_merge($inputData, [
          'slug'             => $_slug,
          'rfq_email'        => $request->post('rfq_email'),
          'rfq_phone'        => $request->post('rfq_phone'),
          'other_name'       => $request->post('other_name'),
          'listing_number'   => $request->post('listing_number'),
          'office_address'   => $request->post('office_address'),
          'office_phone'     => $request->post('office_phone'),
          'yard_location'    => json_encode($yards),
          'website_url'      => $request->post('website_url'),
          'latitude'         => $latitude,
          'longitude'        => $longitude,
          'established_year' => $request->post('established_year'),
          'group'            => $request->post('group'),
          'total_area'       => $request->post('total_area'),
          'water_depth'      => $request->post('water_depth'),
          'contact'          => json_encode($contacts),
          'graving_dock'     => json_encode($gravingDocks),
          'floating_dock'    => json_encode($floatingDocks),
          'ship_repair'      => json_encode($shipRepairs),
          'new_building'     => json_encode($newBuildings),
          'slipway'          => $request->post('slipway'),
          'jetty'            => $request->post('jetty'),
          'certificate'      => $request->post('certificate'),
          'crane'            => $request->post('crane'),
          'service'          => json_encode($service),
          'construction'     => json_encode($construction),
          'branch'           => $_branch ? implode(', ', $_branch) : null,
          'video'            => json_encode($videos),
          'status'           => $request->post('status'),
          'created_by'       => $this->data['auth_data']['id'],
          'updated_by'       => $this->data['auth_data']['id'],
        ]);

        try {
          DB::beginTransaction();

          if (!empty($request->file('logo'))) {
            $inputData['logo'] = $request->file('logo')->store('upload/shipyard/' . date('Y') . '/' . date('m'));
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
          $result = ShipyardModel::create($inputData);

          foreach ($_category as $_val) {
            ShipyardCategoryModel::insertOrIgnore([
              'name' => $_val,
              'code' => Str::slug(trim($_val))
            ]);
          }

          if ($this->data['auth_data']['role'] == 'shipyard') {
            UserShipyardModel::create([
              'shipyard_id' => $result->id,
              'user_id'     => $this->data['auth_data']['id']
            ]);
          }

          // Commit the transaction
          DB::commit();

          return redirect()->route('shipyard.shipyardIndex')->with('__success', 'Data Added.');
        } catch (\Exception $e) {
          // If an exception occurs, rollback the transaction
          DB::rollback();
        }
      } else {
        return response()->json($errors);
      }

      $this->data['errors'] = $errors;
    }

    $shipyards = ShipyardModel::selectRaw("
      shipyards.id,
      shipyards.type,
      shipyards.name,
      shipyards.slug,
      shipyards.location,
      shipyards.category,
      shipyards.status
    ")
      ->where('shipyards.deleted_at', null)
      ->orderBy('shipyards.slug', 'ASC');

    if ($this->data['auth_data']['role'] == 'shipyard') {
      $shipyards->join('user_shipyards', function ($join) {
        $join->on('user_shipyards.shipyard_id', '=', 'shipyards.id');
        $join->where('user_shipyards.user_id', $this->data['auth_data']['id']);
        $join->where('user_shipyards.deleted_at', null);
      });
    }

    $shipyards = $shipyards->get();

    $shipyardLocations  = $mShipyard->getLocations();
    $shipyardCategories = $mShipyardCategory->getAllCategories();

    if (!empty($_location)) {
      $shipyardLocations = array_unique(array_merge($shipyardLocations, [$_location]));
    }

    if (!empty($_category)) {
      $shipyardCategories = array_unique(array_merge($shipyardCategories, $_category));
    }

    $this->data['shipyards']          = $shipyards->toArray();
    $this->data['shipyardLocations']  = $shipyardLocations;
    $this->data['shipyardCategories'] = $shipyardCategories;

    return view('admin/shipyard.v_add', $this->data);
  }

  public function detail(Request $request, $id)
  {
    // check authentication
    $this->_checkAuth();

    $this->data['title'] .= ' Detail';

    $mShipyard         = new ShipyardModel();
    $mShipyardCategory = new ShipyardCategoryModel();

    $shipyard = ShipyardModel::where('shipyards.deleted_at', null)
      ->where('shipyards.id', $id);

    if ($this->data['auth_data']['role'] == 'shipyard') {
      $shipyard->join('user_shipyards', function ($join) {
        $join->on('user_shipyards.shipyard_id', '=', 'shipyards.id');
        $join->where('user_shipyards.user_id', $this->data['auth_data']['id']);
        $join->where('user_shipyards.deleted_at', null);
      });
    }

    $shipyard = $shipyard->first();

    if (empty($shipyard)) {
      abort(404);
    }

    $shipyard = $shipyard->toArray();

    $shipyard['service']      = (!empty($shipyard['service'])) ? json_decode($shipyard['service'], true) : [];
    $shipyard['construction'] = (!empty($shipyard['construction'])) ? json_decode($shipyard['construction'], true) : [];

    if ($request->post()) {
      $_type = $request->post('type');
      $_name = $request->post('name');
      $_slug = Str::slug(trim($_type . ' ' . $_name));

      $_location = $request->post('location');
      $_category = $request->post('category');
      $_branch   = $request->post('branch');

      $inputData = [
        'type'           => $_type,
        'name'           => $_name,
        'location'       => $_location,
        'category'       => $_category ? implode(', ', $_category) : null,
      ];

      $errors = $mShipyard->validate($inputData);

      if (empty($errors) && $request->post('is_submit')) {
        $yards         = [];
        $contacts      = [];
        $gravingDocks  = [];
        $floatingDocks = [];
        $shipRepairs   = [];
        $newBuildings  = [];
        $videos        = [];

        $yardAddress         = $request->post('yard_address');
        $yardPhone           = $request->post('yard_phone');
        $contactName         = $request->post('contact_name');
        $contactPosition     = $request->post('contact_position');
        $contactPhone        = $request->post('contact_phone');
        $contactEmail        = $request->post('contact_email');
        $gravingDockLabel    = $request->post('graving_dock_label');
        $gravingDockValue    = $request->post('graving_dock_value');
        $floatingDockLabel   = $request->post('floating_dock_label');
        $floatingDockValue   = $request->post('floating_dock_value');
        $shipRepairHull      = $request->post('ship_repair_hull');
        $shipRepairOwner     = $request->post('ship_repair_owner');
        $shipRepairType      = $request->post('ship_repair_type');
        $shipRepairDimension = $request->post('ship_repair_dimension');
        $shipRepairDate      = $request->post('ship_repair_date');
        $newBuildingShipName = $request->post('new_building_ship_name');
        $newBuildingShipType = $request->post('new_building_ship_type');
        $newBuildingOwner    = $request->post('new_building_owner');
        $newBuildingDate     = $request->post('new_building_date');
        $newBuildingWorkType = $request->post('new_building_work_type');
        $videoUrl            = $request->post('video_url');

        if (!empty($yardAddress)) {
          foreach ($yardAddress as $_key => $_val) {
            if (!empty($_val) && !empty($yardPhone[$_key])) {
              $yards[] = [
                'address' => $_val,
                'phone'   => $yardPhone[$_key]
              ];
            }
          }
        }

        if (!empty($contactName)) {
          foreach ($contactName as $_key => $_val) {
            if (!empty($_val) && !empty($contactName[$_key])) {
              $contacts[] = [
                'name'     => $_val,
                'position' => $contactPosition[$_key],
                'phone'    => $contactPhone[$_key],
                'email'    => $contactEmail[$_key]
              ];
            }
          }
        }

        if (!empty($gravingDockLabel)) {
          foreach ($gravingDockLabel as $_key => $_val) {
            if (!empty($_val) && !empty($gravingDockValue[$_key])) {
              $gravingDocks[] = [
                'label' => $_val,
                'value' => $gravingDockValue[$_key]
              ];
            }
          }
        }

        if (!empty($floatingDockLabel)) {
          foreach ($floatingDockLabel as $_key => $_val) {
            if (!empty($_val) && !empty($floatingDockValue[$_key])) {
              $floatingDocks[] = [
                'label' => $_val,
                'value' => $floatingDockValue[$_key]
              ];
            }
          }
        }

        if (!empty($shipRepairHull)) {
          foreach ($shipRepairHull as $_key => $_val) {
            if (!empty($_val) && !empty($shipRepairHull[$_key])) {
              $shipRepairs[] = [
                'hull'      => $_val,
                'owner'     => $shipRepairOwner[$_key],
                'type'      => $shipRepairType[$_key],
                'dimension' => $shipRepairDimension[$_key],
                'date'      => $shipRepairDate[$_key]
              ];
            }
          }
        }

        if (!empty($newBuildingShipName)) {
          foreach ($newBuildingShipName as $_key => $_val) {
            if (!empty($_val) && !empty($newBuildingShipName[$_key])) {
              $newBuildings[] = [
                'ship_name' => $_val,
                'ship_type' => $newBuildingShipType[$_key],
                'owner'     => $newBuildingOwner[$_key],
                'date'      => $newBuildingDate[$_key],
                'work_type' => $newBuildingWorkType[$_key]
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

        $service = [
          'ship_repair'   => $request->post('service_shiprepair') ? 1 : 0,
          'ship_building' => $request->post('service_building') ? 1 : 0
        ];

        $construction = [
          'steel'     => $request->post('construction_steel') ? 1 : 0,
          'aluminium' => $request->post('construction_aluminium') ? 1 : 0,
          'other'     => $request->post('construction_other') ? 1 : 0
        ];

        $longitude = $request->post('longitude');
        $latitude = $request->post('latitude');

        $latitude = (!empty($latitude) || $latitude === '0') ? doubleval($latitude) : null;
        $longitude = (!empty($longitude) || $longitude === '0') ? doubleval($longitude) : null;

        $inputData = array_merge($inputData, [
          'slug'             => $_slug,
          'rfq_email'        => $request->post('rfq_email'),
          'rfq_phone'        => $request->post('rfq_phone'),
          'other_name'       => $request->post('other_name'),
          'listing_number'   => $request->post('listing_number'),
          'office_address'   => $request->post('office_address'),
          'office_phone'     => $request->post('office_phone'),
          'yard_location'    => json_encode($yards),
          'website_url'      => $request->post('website_url'),
          'latitude'         => $latitude,
          'longitude'        => $longitude,
          'established_year' => $request->post('established_year'),
          'group'            => $request->post('group'),
          'total_area'       => $request->post('total_area'),
          'water_depth'      => $request->post('water_depth'),
          'contact'          => json_encode($contacts),
          'graving_dock'     => json_encode($gravingDocks),
          'floating_dock'    => json_encode($floatingDocks),
          'ship_repair'      => json_encode($shipRepairs),
          'new_building'     => json_encode($newBuildings),
          'slipway'          => $request->post('slipway'),
          'jetty'            => $request->post('jetty'),
          'certificate'      => $request->post('certificate'),
          'crane'            => $request->post('crane'),
          'service'          => json_encode($service),
          'construction'     => json_encode($construction),
          'branch'           => $_branch ? implode(', ', $_branch) : null,
          'video'            => json_encode($videos),
          'status'           => $request->post('status'),
          'created_by'       => $this->data['auth_data']['id'],
          'updated_by'       => $this->data['auth_data']['id'],
        ]);

        try {
          DB::beginTransaction();

          if (!empty($request->file('logo'))) {
            $inputData['logo'] = $request->file('logo')->store('upload/shipyard/' . date('Y') . '/' . date('m'));
          } else {
            $inputData['logo'] = $shipyard['logo'];
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
          ShipyardModel::where([
            'id' => $id
          ])->update($inputData);

          foreach ($_category as $_val) {
            ShipyardCategoryModel::insertOrIgnore([
              'name' => $_val,
              'code' => Str::slug(trim($_val))
            ]);
          }

          // Commit the transaction
          DB::commit();
        } catch (\Exception $e) {
          // If an exception occurs, rollback the transaction
          DB::rollback();
        }

        return redirect()->route('shipyard.shipyardIndex')->with('__success', 'Data Updated.');
      } else {
        // dd($request->post());
        return response()->json($errors);
      }

      $this->data['errors'] = $errors;
    }

    $shipyards = ShipyardModel::selectRaw("
      shipyards.id,
      shipyards.type,
      shipyards.name,
      shipyards.slug,
      shipyards.location,
      shipyards.category,
      shipyards.status
    ")
      ->where('shipyards.deleted_at', null)
      ->orderBy('shipyards.slug', 'ASC');

    if ($this->data['auth_data']['role'] == 'shipyard') {
      $shipyards->join('user_shipyards', function ($join) {
        $join->on('user_shipyards.shipyard_id', '=', 'shipyards.id');
        $join->where('user_shipyards.user_id', $this->data['auth_data']['id']);
        $join->where('user_shipyards.deleted_at', null);
      });
    }

    $shipyards = $shipyards->get();

    $shipyardLocations  = $mShipyard->getLocations();
    $shipyardCategories = $mShipyardCategory->getAllCategories();

    if (!empty($_location)) {
      $shipyardLocations = array_unique(array_merge($shipyardLocations, [$_location]));
    }

    if (!empty($_category)) {
      $shipyardCategories = array_unique(array_merge($shipyardCategories, $_category));
    }

    $this->data['shipyard']           = $shipyard;
    $this->data['shipyards']          = $shipyards->toArray();
    $this->data['shipyardLocations']  = $shipyardLocations;
    $this->data['shipyardCategories'] = $shipyardCategories;

    return view('admin/shipyard.v_detail', $this->data);
  }

  public function delete(Request $request, $id)
  {
    // check authentication
    $this->_checkAuth();

    ShipyardModel::where([
      'id' => $id
    ])->update([
      'deleted_at' => date('Y-m-d H:i:s'),
      'deleted_by' => $this->data['auth_data']['id'],
    ]);

    return redirect()->route('shipyard.shipyardIndex')->with('__status', 'Data Deleted.');
  }

  protected function _checkAuth()
  {
    if (!in_array($this->data['auth_data']['role'], ['admin', 'superadmin', 'shipyard'])) {
      abort(404);
    }
  }
}
