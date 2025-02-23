<?php

namespace App\Http\Controllers\User;

// use App\User;
use App\Http\Controllers\User\Controller;
use App\Models\ShipyardCategoryModel;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\ShipyardModel;
use App\Models\RfqModel;
use App\Models\UserModel;

class Shipyard extends Controller
{

  public function index(Request $request, $lang = '')
  {
    $mShipyardCategory = new ShipyardCategoryModel();

    $shipyards = ShipyardModel::selectRaw("
      UPPER(name) name
    ")
      ->where('deleted_at', null)
      ->where('status', 'publish')
      ->orderBy('slug', 'ASC')
      ->get();

    $locations = ShipyardModel::selectRaw("
      UPPER(location) location
    ")
      ->where('deleted_at', null)
      ->where('status', 'publish')
      ->groupBy('location')
      ->orderBy('slug', 'ASC')
      ->get();

    $this->data['shipyards']  = $shipyards->toArray();
    $this->data['locations']  = $locations->toArray();
    $this->data['categories'] = $mShipyardCategory->getAllCategories();

    return view('user.shipyard.v_index', $this->data);
  }

  public function detail(Request $request, $id = '', $lang = '')
  {
    $shipyard = ShipyardModel::where('shipyards.deleted_at', null)
      ->where('shipyards.id', $id)
      ->where('status', 'publish')
      ->first();

    $shipyardBranchs = ShipyardModel::where('deleted_at', null)
      ->whereIn('id', explode(', ', $shipyard['branch']))
      ->where('status', 'publish')
      ->get();

    $this->data['shipyard']        = $shipyard->toArray();
    $this->data['shipyardBranchs'] = $shipyardBranchs->toArray();

    return view('user.shipyard.v_detail', $this->data);
  }

  public function datatable(Request $request, $lang = '')
  {
    $shipyards = ShipyardModel::selectRaw("
      id,
      type,
      UPPER(name) name,
      UPPER(other_name) other_name,
      slug,
      UPPER(location) location,
      UPPER(category) category
    ")
      ->where('deleted_at', null)
      ->where('status', 'publish')
      ->orderBy('slug', 'ASC')
      ->get();

    return Datatables::of($shipyards)->make();
  }

  public function contact(Request $request, $id = '', $lang = '')
  {
    $authData = $this->data['auth_data'];

    if ($authData['member_type'] != 'premium') {
      return redirect(env('DOMAIN_USER_URL'));
    }

    $shipyard = ShipyardModel::where('shipyards.deleted_at', null)
      ->where('shipyards.id', $id)
      ->where('status', 'publish')
      ->first();

    if (empty($shipyard)) {
      return redirect(env('DOMAIN_USER_URL'));
    } elseif (empty($shipyard->rfq_email) && empty($shipyard->rfq_phone)) {
      return redirect(env('DOMAIN_USER_URL'));
    }

    if ($request->post('rfq_type')) {
      $rfqType = $request->post('rfq_type');
      $errors = [];

      if ($rfqType == 'wa') {
        $message = $request->post('message');

        if (empty($message)) {
          $errors[] = 'Please input message before send.';
        }

        if (empty($errors)) {
          // dd($this->data['auth_data']);
          $userData = UserModel::where('id', $this->data['auth_data']['id'])
            ->where('deleted_at', null)
            ->where('status', 1)
            ->first();

          $sendData = [
            'name'     => $userData->name,
            'position' => $userData->position,
            'phone'    => $userData->phone,
            'email'    => $userData->email,
            'message'  => $message,
          ];

          $sendMessage[] = "Hello {$shipyard->name},";
          $sendMessage[] = 'I tried to contact your Shipyard from Dockyard.ID';
          $sendMessage[] = '';
          $sendMessage[] = 'Here is my contact data:';

          foreach ($sendData as $key => $value) {
            $sendMessage[] = $key . ': ' . $value;
          }

          RfqModel::create([
            'type'       => 'wa',
            'user_id'    => $userData->id,
            'data_id'    => $shipyard->id,
            'data_type'  => 'shipyards',
            'message'    => $message,
            'data'       => json_encode($sendData),
            'send_at'    => date('Y-m-d H:i:s'), 
            'created_by' => $userData->id,
            'updated_by' => $userData->id,
          ]);

          $this->data['sendMessage'] = implode('%0A', $sendMessage);
        }
      } elseif ($rfqType == 'email') {
        $message = $request->post('message');
        $cv      = $request->file('cv');

        if (empty($message)) {
          $errors[] = 'Please input message before send.';
        }

        if (empty($cv)) {
          $errors[] = 'Please upload CV before send.';
        }

        if (empty($errors)) {
          $userData = UserModel::where('id', $this->data['auth_data']['id'])
            ->where('deleted_at', null)
            ->where('status', 1)
            ->first();

          $cvFileName = $cv->store('upload/cv/' . date('Y') . '/' . date('m'));

          $sendData = [
            'name'     => $userData->name,
            'position' => $userData->position,
            'phone'    => $userData->phone,
            'email'    => $userData->email,
            'message'  => $message,
            'cv'       => 'https://cdn.dockyard.id/' . $cvFileName,
          ];

          $sendMessage[] = "Hello {$shipyard->name},";
          $sendMessage[] = 'I tried to contact your Shipyard from Dockyard.ID';
          $sendMessage[] = '';
          $sendMessage[] = 'Here is my contact data:';

          foreach ($sendData as $key => $value) {
            $sendMessage[] = $key . ': ' . $value;
          }

          $sendMessage[] = '';
          $sendMessage[] = 'Thanks.';

          $sendData['send_message'] = $sendMessage;
          
          RfqModel::create([
            'type'       => 'email',
            'user_id'    => $userData->id,
            'data_id'    => $shipyard->id,
            'data_type'  => 'shipyards',
            'cv'         => $cvFileName,
            'message'    => $message,
            'data'       => json_encode($sendData),
            'email_to'   => $shipyard->rfq_email,
            'created_by' => $userData->id,
            'updated_by' => $userData->id,
          ]);

          return redirect()->route('shipyard.shipyardContact', ['id' => $id])->with('success', 'Send RFQ Contact Success.');
        }
      } else {
        return redirect(env('DOMAIN_USER_URL'));
      }

      $this->data['errors'] = $errors;
    }


    $this->data['shipyard'] = $shipyard;

    return view('user.shipyard.v_rfq', $this->data);
  }

  public function pdf(Request $request, $id = '', $lang = '')
  {
    $shipyard = ShipyardModel::where('shipyards.deleted_at', null)
      ->where('shipyards.id', $id)
      ->where('status', 'publish')
      ->first();

    $shipyardBranchs = ShipyardModel::where('deleted_at', null)
      ->whereIn('id', explode(', ', $shipyard['branch']))
      ->where('status', 'publish')
      ->get();

    $this->data['shipyard']        = $shipyard->toArray();
    $this->data['shipyardBranchs'] = $shipyardBranchs->toArray();

    $pdf = Pdf::loadView('user.shipyard.v_pdf', $this->data);

    $pdfName = strtoupper($shipyard['type']) . ' ' . strtoupper($shipyard['name']);

    return $pdf->download($pdfName . '.pdf');
  }
}
