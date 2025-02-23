<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

use App\Models\NewsModel;

use Yajra\DataTables\DataTables;

/**
 * Controller
 * 
 * @author Saka Mahendra Arioka
 *         saka@sakarioka.com
 *         +6285338845666
 */
class News extends Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['title'] = 'News';
  }

  // method index (default)
  public function index(Request $request)
  {
    // check authentication
    $this->_checkAuth();

    // set view
    return view('admin/news.v_index', $this->data);
  }

  public function add(Request $request)
  {
    // check authentication
    $this->_checkAuth();

    $this->data['title'] .= ' Add New';

    $mNews = new NewsModel();

    if ($request->post()) {
      $title       = $request->post('title');
      $description = $request->post('description');
      $content     = $request->post('content');
      $category    = $request->post('category');
      $startDate   = $request->post('start_date');
      $status      = $request->post('status');

      $inputData = [
        'title'       => $title,
        'description' => $description,
        'content'     => $content,
        'category'    => Str::slug($category, ' '),
        'start_date'  => $startDate ? date('Y-m-d', strtotime($startDate)) : null,
        'status'      => $status == 'publish' ? 'publish' : 'draft',
        'created_by'  => $this->data['auth_data']['id'],
        'updated_by'  => $this->data['auth_data']['id'],
      ];

      $errors = $mNews->validate($inputData);

      if (empty($request->file('image'))) {
        $errors['image'] = 'Select file to upload.';
      }

      if (empty($errors) && $request->post('is_submit')) {
        try {
          DB::beginTransaction();

          $inputData['image'] = $request->file('image')->store('upload/news/' . date('Y') . '/' . date('m'));

          // Perform your database operations using Eloquent here
          NewsModel::create($inputData);

          // Commit the transaction
          DB::commit();

          return redirect()->route('news.newsIndex')->with('__success', 'Data Added.');
        } catch (\Exception $e) {
          dd($e);
          // If an exception occurs, rollback the transaction
          DB::rollback();
        }
      } else {
        return response()->json($errors);
      }

      $this->data['errors'] = $errors;
    }

    $this->data['newsCategories'] = NewsModel::where('deleted_at', null)->distinct()->pluck('category')->toArray();

    return view('admin/news.v_add', $this->data);
  }

  public function detail(Request $request, $id)
  {
    // check authentication
    $this->_checkAuth();

    $this->data['title'] .= ' Add New';

    $mNews = new NewsModel();

    $news = NewsModel::where('id', $id)
      ->where('deleted_at', null)
      ->first()
      ->toArray();

    if (empty($news)) {
      abort(404);
    }

    if ($request->post()) {
      $title       = $request->post('title');
      $description = $request->post('description');
      $content     = $request->post('content');
      $category    = $request->post('category');
      $startDate   = $request->post('start_date');
      $status      = $request->post('status');

      $inputData = [
        'title'       => $title,
        'description' => $description,
        'content'     => $content,
        'category'    => Str::slug($category, ' '),
        'start_date'  => $startDate ? date('Y-m-d', strtotime($startDate)) : null,
        'status'      => $status == 'publish' ? 'publish' : 'draft',
        'created_by'  => $this->data['auth_data']['id'],
        'updated_by'  => $this->data['auth_data']['id'],
      ];

      $errors = $mNews->validate($inputData);

      if (empty($errors) && $request->post('is_submit')) {
        try {
          DB::beginTransaction();

          if (!empty($request->file('image'))) {
            $inputData['image'] = $request->file('image')->store('upload/news/' . date('Y') . '/' . date('m'));
          }

          // Perform your database operations using Eloquent here
          NewsModel::where('id', $id)->update($inputData);

          // Commit the transaction
          DB::commit();

          return redirect()->route('news.newsIndex')->with('__success', 'Data Updated.');
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

    $this->data['news'] = $news;
    $this->data['newsCategories'] = NewsModel::where('deleted_at', null)->distinct()->pluck('category')->toArray();

    return view('admin/news.v_detail', $this->data);
  }

  public function delete(Request $request, $id)
  {
    NewsModel::where('id', $id)->update(['deleted_at' => DB::raw('NOW()')]);
    return redirect()->route('news.newsIndex')->with('__success', 'Data Deleted.');
  }

  public function datatable(Request $request)
  {
    // check authentication
    $this->_checkAuth();

    $news = NewsModel::where('news.deleted_at', null);

    return Datatables::of($news)->make();
  }

  protected function _checkAuth()
  {
    if (!in_array($this->data['auth_data']['role'], ['admin', 'superadmin', 'developer'])) {
      abort(404);
    }
  }
}
