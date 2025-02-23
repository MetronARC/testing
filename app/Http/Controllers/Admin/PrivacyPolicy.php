<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\PrivacyPolicyModel;

/**
 * Controller 
 * 
 * @author Saka Mahendra Arioka
 *         saka@sakarioka.com
 *         +6285338845666
 */
class PrivacyPolicy extends Controller {

  public function __construct()
  {
    parent::__construct();
    
    $this->data['title'] = 'Privacy & Policy';
  }

  // method index (default)
  public function index(Request $request)
  {
    $this->data['privacy_policies'] = PrivacyPolicyModel::where('deleted_at', null)
                                                       ->orderBy('order_number', 'asc')
                                                       ->get()
                                                       ->toArray();

    // set view
    return view('admin/privacy_policy.v_index', $this->data);
  }

  public function add(Request $request)
  {
    $this->data['title'] .= ' Add New';

    if ($request->post()) {
      $m_privacy_policy = new PrivacyPolicyModel();

      $errors = $m_privacy_policy->validate($request->post());

      if (empty($errors)) {
        DB::transaction(function() use($request, &$id) {
          DB::insert('insert into privacy_policy (title_en, title_id, description_en, description_id) values (?, ?, ?, ?)', [
            $request->post('title_en'),
            $request->post('title_id'),
            $request->post('description_en'),
            $request->post('description_id')
          ]);

          $id = DB::getPdo()->lastInsertId();

          DB::update('update privacy_policy set order_number = id where id = ?', [$id]);
        });

        return redirect()->route('privacyPolicyIndex')->with('__status', 'Data Added.');
      }

      $this->data['errors'] = $errors;
    }

    return view('admin/privacy_policy.v_add', $this->data);
  }

  public function detail(Request $request, $id)
  {
    $this->data['title'] .= ' Detail';

    $privacy_policy = PrivacyPolicyModel::where('deleted_at', null)
                                        ->where('id', $id)
                                        ->first();

    if ($request->post()) {
      $m_privacy_policy = new PrivacyPolicyModel();

      $errors = $m_privacy_policy->validate($request->post());

      if (empty($errors)) {
        $update_data = [
          'title_en'        => $request->post('title_en'),
          'title_id'        => $request->post('title_id'),
          'description_en' => $request->post('description_en'),
          'description_id' => $request->post('description_id')
        ];

        PrivacyPolicyModel::where('id', $id)
                    ->where('deleted_at', null)
                    ->update($update_data);

        return redirect()->route('privacyPolicyDetail', ['id' => $id])->with('__status', 'Data Updated.');
      }

      $this->data['errors'] = $errors;
    }

    $this->data['privacy_policy'] = !empty($privacy_policy) ? $privacy_policy->toArray() : [];

    return view('admin/privacy_policy.v_detail', $this->data);
  }

  public function move(Request $request, $id, $order)
  {
    $privacy_policy = PrivacyPolicyModel::where('id', $id)
                                        ->where('deleted_at', null)
                                        ->first()
                                        ->toArray();

    if ($order == 'up') {
      $temp_privacy_policy = PrivacyPolicyModel::where('order_number', '<', $privacy_policy['order_number'])
                                               ->where('deleted_at', null)
                                               ->orderBy('order_number', 'desc')
                                               ->first()
                                               ->toArray();
    } else {
      $temp_privacy_policy = PrivacyPolicyModel::where('order_number', '>', $privacy_policy['order_number'])
                                               ->where('deleted_at', null)
                                               ->orderBy('order_number', 'asc')
                                               ->first()
                                               ->toArray();
    }

    DB::transaction(function() use($privacy_policy, $temp_privacy_policy) {
      DB::update('update privacy_policy set order_number = ? where id = ? and deleted_at is null', [
        $temp_privacy_policy['order_number'],
        $privacy_policy['id']
      ]);

      DB::update('update privacy_policy set order_number = ? where id = ? and deleted_at is null', [
        $privacy_policy['order_number'],
        $temp_privacy_policy['id']
      ]);
    });

    return redirect()->route('privacyPolicyIndex')->with('__status', 'Data Updated.');
  }

  public function delete(Request $request, $id)
  {
    PrivacyPolicyModel::where('id', $id)
                      ->where('deleted_at', null)
                      ->update(['deleted_at' => date('Y-m-d H:i:s')]);

    return redirect()->route('privacyPolicyIndex')->with('__status', 'Data Deleted.');
  }
}
