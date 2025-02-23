<?php

namespace App\Http\Controllers\User;

// use App\User;
use App\Http\Controllers\User\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\TenderModel;
use App\Models\RfqModel;
use App\Models\UserModel;

class Tender extends Controller
{ 
  public function index(Request $request, $lang = '')
  {
    if (empty($this->data['auth_data'])) {
      return redirect(env('DOMAIN_AUTH_LOGIN_URL').'?'.http_build_query(['redirect' => url()->current()]));
    }
    
    return view('user.tender.v_index', $this->data);
  }

  public function detail(Request $request, $id = '', $tenderNumber = '', $lang = '')
  {
    if (empty($this->data['auth_data'])) {
      return redirect(env('DOMAIN_AUTH_LOGIN_URL').'?'.http_build_query(['redirect' => url()->current()]));
    }
    
    $tender = TenderModel::selectRaw("
      tenders.*,
      shipyards.logo,
      CONCAT(UPPER(shipyards.type), ' ', shipyards.name) company_name
    ")
    ->join('shipyards', function ($join) {
      $join->on('shipyards.id', '=', 'tenders.shipyard_id');
      $join->where('shipyards.deleted_at', null);
    })
      ->where('tenders.deleted_at', null)
      ->where('tenders.id', $id)
      ->where('tenders.status', 'publish')
      ->first()
      ->toArray();

    // dd($tender);

    $this->data['tender'] = $tender;

    return view('user.tender.v_detail', $this->data);
  }

  public function datatable(Request $request, $lang = '')
  {
    if (empty($this->data['auth_data'])) {
      return redirect(env('DOMAIN_AUTH_LOGIN_URL').'?'.http_build_query(['redirect' => url()->current()]));
    }

    $tenders = TenderModel::selectRaw("
      tenders.id,
      tenders.tender_number,
      CONCAT(UPPER(shipyards.type), ' ', shipyards.name) company_name,
      tenders.title,
      tenders.description,
      tenders.tender_status
    ")
      ->join('shipyards', function ($join) {
        $join->on('shipyards.id', '=', 'tenders.shipyard_id');
        $join->where('shipyards.deleted_at', null);
      })
      ->where('tenders.deleted_at', null)
      ->where('tenders.status', 'publish')
      ->get();

    return Datatables::of($tenders)->make();
  }

  public function contact(Request $request, $id = '', $lang = '')
  {
    if (empty($this->data['auth_data'])) {
      return redirect(env('DOMAIN_AUTH_LOGIN_URL').'?'.http_build_query(['redirect' => url()->current()]));
    }
    
    $tender = TenderModel::selectRaw("
      tenders.*,
      shipyards.logo,
      CONCAT(UPPER(shipyards.type), ' ', shipyards.name) company_name
    ")
      ->join('shipyards', function ($join) {
        $join->on('shipyards.id', '=', 'tenders.shipyard_id');
        $join->where('shipyards.deleted_at', null);
      })
      ->where('tenders.deleted_at', null)
      ->where('tenders.id', $id)
      ->where('tenders.status', 'publish')
      ->where('tenders.tender_status', 'open')
      ->whereDate('tenders.closed_date', '>=', now())
      ->first();

    if (empty($tender)) {
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
          $userData = UserModel::where('id', $this->data['auth_data']['id'])
            ->where('deleted_at', null)
            ->where('status', 1)
            ->first();

          $sendData = [
            'name'     => $userData->name,
            'phone'    => $userData->phone,
            'email'    => $userData->email,
            'message'  => $message,
          ];

          $sendMessage[] = 'Hello '.$tender->company_name.',';
          $sendMessage[] = 'About your Tender '.$tender->title.'';
          $sendMessage[] = '';
          $sendMessage[] = 'Here is my contact data:';

          foreach ($sendData as $key => $value) {
            $sendMessage[] = $key . ': ' . $value;
          }

          $sendMessage[] = '';
          $sendMessage[] = 'Thanks.';

          RfqModel::create([
            'type'       => 'wa',
            'user_id'    => $userData->id,
            'data_id'    => $tender->id,
            'data_type'  => 'tenders',
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

        if (empty($message)) {
          $errors[] = 'Please input message before send.';
        }

        if (empty($errors)) {
          $userData = UserModel::where('id', $this->data['auth_data']['id'])
            ->where('deleted_at', null)
            ->where('status', 1)
            ->first();

          $sendData = [
            'name'     => $userData->name,
            'phone'    => $userData->phone,
            'email'    => $userData->email,
            'message'  => $message,
          ];

          $sendMessage[] = 'Hello "'.$tender->company_name.',"';
          $sendMessage[] = 'About your Tender "'.$tender->title.'"';
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
            'data_id'    => $tender->id,
            'data_type'  => 'tenders',
            'message'    => $message,
            'data'       => json_encode($sendData),
            'email_to'   => $tender->email,
            'created_by' => $userData->id,
            'updated_by' => $userData->id,
          ]);

          return redirect()->route('tender.tenderContact', ['id' => $id])->with('success', 'Send Join Tender Message Success.');
        }
      } else {
        return redirect(env('DOMAIN_USER_URL'));
      }

      $this->data['errors'] = $errors;
    }


    $this->data['tender'] = $tender;

    return view('user.tender.v_rfq', $this->data);
  }
}
