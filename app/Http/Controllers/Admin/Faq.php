<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\FaqModel;

/**
 * Controller
 * 
 * @author Saka Mahendra Arioka
 *         saka@sakarioka.com
 *         +6285338845666
 */
class Faq extends Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['title'] = 'FAQs';
  }

  // method index (default)
  public function index(Request $request)
  {
    $this->data['faqs'] = FaqModel::where('deleted_at', null)
      ->orderBy('order_number', 'asc')
      ->get()
      ->toArray();

    // set view
    return view('admin/faq.v_index', $this->data);
  }

  public function add(Request $request)
  {
    $this->data['title'] .= ' Add New';

    if ($request->post()) {
      $m_faq = new FaqModel();

      $errors = $m_faq->validate($request->post());

      if (empty($errors)) {
        DB::transaction(function () use ($request, &$id) {
          DB::insert('insert into faq (title_en, title_id, description_en, description_id) values (?, ?, ?, ?)', [
            $request->post('title_en'),
            $request->post('title_id'),
            $request->post('description_en'),
            $request->post('description_id')
          ]);

          $id = DB::getPdo()->lastInsertId();

          DB::update('update faq set order_number = id where id = ?', [$id]);
        });

        return redirect()->route('faqIndex')->with('__status', 'Data Added.');
      }

      $this->data['errors'] = $errors;
    }

    return view('admin/faq.v_add', $this->data);
  }

  public function detail(Request $request, $id)
  {
    $this->data['title'] .= ' Detail';

    $faq = FaqModel::where('deleted_at', null)
      ->where('id', $id)
      ->first();

    if ($request->post()) {
      $m_faq = new FaqModel();

      $errors = $m_faq->validate($request->post());

      if (empty($errors)) {
        $update_data = [
          'title_en'        => $request->post('title_en'),
          'title_id'        => $request->post('title_id'),
          'description_en' => $request->post('description_en'),
          'description_id' => $request->post('description_id')
        ];

        FaqModel::where('id', $id)
          ->where('deleted_at', null)
          ->update($update_data);

        return redirect()->route('faqDetail', ['id' => $id])->with('__status', 'Data Updated.');
      }

      $this->data['errors'] = $errors;
    }

    $this->data['faq'] = !empty($faq) ? $faq->toArray() : [];

    return view('admin/faq.v_detail', $this->data);
  }

  public function move(Request $request, $id, $order)
  {
    $faq = FaqModel::where('id', $id)
      ->where('deleted_at', null)
      ->first()
      ->toArray();

    if ($order == 'up') {
      $temp_faq = FaqModel::where('order_number', '<', $faq['order_number'])
        ->where('deleted_at', null)
        ->orderBy('order_number', 'desc')
        ->first()
        ->toArray();
    } else {
      $temp_faq = FaqModel::where('order_number', '>', $faq['order_number'])
        ->where('deleted_at', null)
        ->orderBy('order_number', 'asc')
        ->first()
        ->toArray();
    }

    DB::transaction(function () use ($faq, $temp_faq) {
      DB::update('update faq set order_number = ? where id = ? and deleted_at is null', [
        $temp_faq['order_number'],
        $faq['id']
      ]);

      DB::update('update faq set order_number = ? where id = ? and deleted_at is null', [
        $faq['order_number'],
        $temp_faq['id']
      ]);
    });

    return redirect()->route('faqIndex')->with('__status', 'Data Updated.');
  }

  public function delete(Request $request, $id)
  {
    FaqModel::where('id', $id)
      ->where('deleted_at', null)
      ->update(['deleted_at' => date('Y-m-d H:i:s')]);

    return redirect()->route('faqIndex')->with('__status', 'Data Deleted.');
  }
}
