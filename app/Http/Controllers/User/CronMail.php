<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\User\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Mail\RegistrationEmail;
use App\Mail\TemporaryPasswordEmail;
use App\Mail\RfqEmail;

use Illuminate\Support\Facades\Mail;

use App\Models\UserModel;
use App\Models\RfqModel;
use App\Models\ShipyardModel;

/**
 * Controller
 * 
 * @author Saka Mahendra Arioka
 *         saka@sakarioka.com
 *         +6285338845666
 */
class CronMail extends Controller
{
  public function pendingRegistration(Request $request)
  {
    $users = UserModel::where('users.mail_register_send_at', null)
      ->where('users.status', 0)
      ->where('users.deleted_at', null)
      ->get();

    foreach ($users as $user) {
      $eRegistration = new RegistrationEmail($user);

      dump("try to send mail to {$user->email}");
      Mail::send($eRegistration);

      if (count(Mail::failures()) == 0) {
        dump("send mail success to {$user->email}");
        UserModel::where('id', $user->id)->update(['mail_register_send_at' => DB::raw('NOW()')]);
      } else {
        dump("send mail failed to {$user->email}");
      }
    }

    die('sending mail..');
  }

  public function temporaryPassword(Request $request)
  {
    $users = UserModel::where('users.status', 1)
      ->whereRaw('users.temp_password IS NOT NULL')
      ->where('users.mail_temp_password_send_at', null)
      ->where('users.deleted_at', null)
      ->get();

    foreach ($users as $user) {
      $eTemporaryPassword = new TemporaryPasswordEmail($user);

      dump("try to send mail to {$user->email}");
      Mail::send($eTemporaryPassword);

      if (count(Mail::failures()) == 0) {
        dump("send mail success to {$user->email}");
        UserModel::where('id', $user->id)->update(['mail_temp_password_send_at' => DB::raw('NOW()')]);
      } else {
        dump("send mail failed to {$user->email}");
      }
    }

    die('sending mail..');
  }

  public function rfq(Request $request)
  {
    $rfqs = RfqModel::where('send_at', null)
      ->where('type', 'email')
      ->whereNotNull('email_to')
      ->where('email_try', '<', 2)
      ->get()
      ->toArray();

    foreach ($rfqs as $value) {
      $user = json_decode($value['data'], true);

      $data = [];

      // switch ($value['data_type']) {
      //   case 'shipyards':
      //     $data = ShipyardModel::where('id', $value['data_id'])
      //       ->where('deleted_at', null)
      //       ->first()
      //       ->toArray();
      //     break;
      // }

      // if (!empty($data)) {
      $eRfq = new RfqEmail($user, $value);

      RfqModel::where('id', $value['id'])->increment('email_try', 1);;

      dump("try to send mail to {$value['email_to']}");
      Mail::send($eRfq);

      if (count(Mail::failures()) == 0) {
        dump("send mail success to {$value['email_to']}");
        RfqModel::where('id', $value['id'])->update(['send_at' => DB::raw('NOW()')]);
      } else {
        dump("send mail failed to {$value['email_to']}");
      }
      // } else {
      //   RfqModel::where('id', $value['id'])->update([
      //     'send_at' => DB::raw('NOW()'),
      //     'remark'  => 'data not found, message is considered sent.'
      //   ]);
      // }
    }

    die('sending mail..');
  }
}
