<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

use App\Models\TenderModel;
use App\Models\ShipyardModel;

use Yajra\DataTables\DataTables;

/**
 * Controller
 * 
 * @author Saka Mahendra Arioka
 *         saka@sakarioka.com
 *         +6285338845666
 */
class Tender extends Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['title'] = 'Tender';
  }

  // method index (default)
  public function index(Request $request)
  {
    // check authentication
    $this->_checkAuth();

    // set view
    return view('admin/tender.v_index', $this->data);
  }

  public function add(Request $request)
  {
    // check authentication
    $this->_checkAuth();

    $this->data['title'] .= ' Add New';

    $mTender = new TenderModel();

    if ($request->post()) {
      $shipyardId   = $request->post('shipyard_id');
      $phone        = $request->post('phone');
      $email        = $request->post('email');
      $tenderStatus = $request->post('tender_status');
      $closedDate   = $request->post('closed_date');
      $status       = $request->post('status');
      $title        = $request->post('title');
      $description  = $request->post('description');

      $inputData = [
        'shipyard_id'   => $shipyardId,
        'phone'         => $phone,
        'email'         => $email,
        'title'         => $title,
        'description'   => $description,
        'tender_status' => strtolower($tenderStatus) == 'open' ? 'open' : 'closed',
        'closed_date'   => $closedDate ? date('Y-m-d', strtotime($closedDate)) : null,
        'status'        => $status == 'publish' ? 'publish' : 'draft',
        'created_by'    => $this->data['auth_data']['id'],
        'updated_by'    => $this->data['auth_data']['id'],
      ];

      $errors = $mTender->validate($inputData);

      if (empty($errors) && $request->post('is_submit')) {
        try {
          DB::beginTransaction();

          // Perform your database operations using Eloquent here
          $result = TenderModel::create($inputData);

          $countTodayData = TenderModel::whereDate('created_at', today())->count();
          $tenderNumber   = date('Ymd').addZeroBeforeNumber($countTodayData, 3);

          TenderModel::where('id', $result->id)
            ->update(['tender_number' => $tenderNumber]);

          // Commit the transaction
          DB::commit();

          return redirect()->route('tender.tenderIndex')->with('__success', 'Data Added.');
        } catch (\Exception $e) {
          // dd($e);
          // If an exception occurs, rollback the transaction
          DB::rollback();
        }
      } else {
        return response()->json($errors);
      }

      $this->data['errors'] = $errors;
    }

    $shipyards = ShipyardModel::where('shipyards.deleted_at', null)
      ->where('deleted_at', null)
      ->orderBy('shipyards.slug', 'ASC')
      ->get()
      ->toArray();

    $this->data['shipyards'] = $shipyards;

    return view('admin/tender.v_add', $this->data);
  }

  public function detail(Request $request, $id)
  {
    // check authentication
    $this->_checkAuth();

    $this->data['title'] .= ' Add New';

    $mTender = new TenderModel();

    $tender = TenderModel::where('id', $id)
      ->where('deleted_at', null)
      ->first()
      ->toArray();

    if (empty($tender)) {
      abort(404);
    }

    if ($request->post()) {
      $shipyardId   = $request->post('shipyard_id');
      $phone        = $request->post('phone');
      $email        = $request->post('email');
      $tenderStatus = $request->post('tender_status');
      $closedDate   = $request->post('closed_date');
      $status       = $request->post('status');
      $title        = $request->post('title');
      $description  = $request->post('description');

      $inputData = [
        'shipyard_id'   => $shipyardId,
        'phone'         => $phone,
        'email'         => $email,
        'title'         => $title,
        'description'   => $description,
        'tender_status' => strtolower($tenderStatus) == 'open' ? 'open' : 'closed',
        'closed_date'   => $closedDate ? date('Y-m-d', strtotime($closedDate)) : null,
        'status'        => $status == 'publish' ? 'publish' : 'draft',
        'updated_by'    => $this->data['auth_data']['id'],
      ];

      $errors = $mTender->validate($inputData);

      if (empty($errors) && $request->post('is_submit')) {
        try {
          DB::beginTransaction();

          // Perform your database operations using Eloquent here
          TenderModel::where('id', $id)->update($inputData);

          // Commit the transaction
          DB::commit();

          return redirect()->route('tender.tenderIndex')->with('__success', 'Data Updated.');
        } catch (\Exception $e) {
          // dd($e);
          // If an exception occurs, rollback the transaction
          DB::rollback();
        }
      } else {
        return response()->json($errors);
      }

      $this->data['errors'] = $errors;
    }

    $shipyards = ShipyardModel::where('shipyards.deleted_at', null)
      ->where('deleted_at', null)
      ->orderBy('shipyards.slug', 'ASC')
      ->get()
      ->toArray();

    $this->data['tender']    = $tender;
    $this->data['shipyards'] = $shipyards;

    return view('admin/tender.v_detail', $this->data);
  }

  public function delete(Request $request, $id)
  {
    TenderModel::where('id', $id)->update(['deleted_at' => DB::raw('NOW()')]);
    return redirect()->route('tender.tenderIndex')->with('__success', 'Data Deleted.');
  }

  public function datatable(Request $request)
  {
    // check authentication
    $this->_checkAuth();

    $tenders = TenderModel::selectRaw("
      tenders.id,
      tenders.tender_number,
      tenders.title,
      tenders.description,
      CONCAT(UPPER(shipyards.type), ' ', shipyards.name) company_name,
      tenders.tender_status,
      tenders.status
    ")
      ->join('shipyards', function($join) {
        $join->on('shipyards.id', '=', 'tenders.shipyard_id');
        $join->where('shipyards.deleted_at', null);
      })
      ->where('tenders.deleted_at', null);

    return Datatables::of($tenders)->make();
  }

  protected function _checkAuth()
  {
    if (!in_array($this->data['auth_data']['role'], ['admin', 'superadmin', 'developer'])) {
      abort(404);
    }
  }
}
