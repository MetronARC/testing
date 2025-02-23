<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\TermConditionModel;

/**
 * Controller
 * 
 * @author Saka Mahendra Arioka
 *         saka@sakarioka.com
 *         +6285338845666
 */
class TermCondition extends Controller {

  public function __construct()
  {
    parent::__construct();
    
    $this->data['title'] = 'Terms & Conditions';
  }

  // method index (default)
  public function index(Request $request)
  {
    $this->data['term_conditions'] = TermConditionModel::where('deleted_at', null)
                                                       ->orderBy('order_number', 'asc')
                                                       ->get()
                                                       ->toArray();

    // set view
    return view('admin/term_condition.v_index', $this->data);
  }

  public function add(Request $request)
  {
    $this->data['title'] .= ' Add New';

    if ($request->post()) {
      $m_term_condition = new TermConditionModel();

      $errors = $m_term_condition->validate($request->post());

      if (empty($errors)) {
        DB::transaction(function() use($request, &$id) {
          DB::insert('insert into term_condition (title_en, title_id, description_en, description_id) values (?, ?, ?, ?)', [
            $request->post('title_en'),
            $request->post('title_id'),
            $request->post('description_en'),
            $request->post('description_id')
          ]);

          $id = DB::getPdo()->lastInsertId();

          DB::update('update term_condition set order_number = id where id = ?', [$id]);
        });

        return redirect()->route('termConditionIndex')->with('__status', 'Data Added.');
      }

      $this->data['errors'] = $errors;
    }

    return view('admin/term_condition.v_add', $this->data);
  }

  public function detail(Request $request, $id)
  {
    $this->data['title'] .= ' Detail';

    $term_condition = TermConditionModel::where('deleted_at', null)
                                        ->where('id', $id)
                                        ->first();

    if ($request->post()) {
      $m_term_condition = new TermConditionModel();

      $errors = $m_term_condition->validate($request->post());

      if (empty($errors)) {
        $update_data = [
          'title_en'        => $request->post('title_en'),
          'title_id'        => $request->post('title_id'),
          'description_en' => $request->post('description_en'),
          'description_id' => $request->post('description_id')
        ];

        TermConditionModel::where('id', $id)
                    ->where('deleted_at', null)
                    ->update($update_data);

        return redirect()->route('termConditionDetail', ['id' => $id])->with('__status', 'Data Updated.');
      }

      $this->data['errors'] = $errors;
    }

    $this->data['term_condition'] = !empty($term_condition) ? $term_condition->toArray() : [];

    return view('admin/term_condition.v_detail', $this->data);
  }

  public function move(Request $request, $id, $order)
  {
    $term_condition = TermConditionModel::where('id', $id)
                                        ->where('deleted_at', null)
                                        ->first()
                                        ->toArray();

    if ($order == 'up') {
      $temp_term_condition = TermConditionModel::where('order_number', '<', $term_condition['order_number'])
                                               ->where('deleted_at', null)
                                               ->orderBy('order_number', 'desc')
                                               ->first()
                                               ->toArray();
    } else {
      $temp_term_condition = TermConditionModel::where('order_number', '>', $term_condition['order_number'])
                                               ->where('deleted_at', null)
                                               ->orderBy('order_number', 'asc')
                                               ->first()
                                               ->toArray();
    }

    DB::transaction(function() use($term_condition, $temp_term_condition) {
      DB::update('update term_condition set order_number = ? where id = ? and deleted_at is null', [
        $temp_term_condition['order_number'],
        $term_condition['id']
      ]);

      DB::update('update term_condition set order_number = ? where id = ? and deleted_at is null', [
        $term_condition['order_number'],
        $temp_term_condition['id']
      ]);
    });

    return redirect()->route('termConditionIndex')->with('__status', 'Data Updated.');
  }

  public function delete(Request $request, $id)
  {
    TermConditionModel::where('id', $id)
                      ->where('deleted_at', null)
                      ->update(['deleted_at' => date('Y-m-d H:i:s')]);

    return redirect()->route('termConditionIndex')->with('__status', 'Data Deleted.');
  }
}
