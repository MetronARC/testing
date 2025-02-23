<?php

namespace App\Http\Controllers\User;

// use App\User;
use App\Http\Controllers\User\Controller;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;

use App\Models\JobModel;

class Job extends Controller
{

  public function index(Request $request, $lang = '')
  {
    return view('user.job.v_index', $this->data);
  }

  public function detail(Request $request, $id = '', $lang = '')
  {
    $job = JobModel::selectRaw("
      jobs.*
    ")
      ->where('jobs.deleted_at', null)
      ->where('jobs.id', $id)
      ->first();

    $this->data['job'] = $job;

    return view('user.job.v_detail', $this->data);
  }

  public function datatable(Request $request, $lang = '')
  {
    $jobs = JobModel::selectRaw("
      id,
      slug,
      position,
      company,
      posted_start_at,
      posted_end_at,
      status
    ")
      ->where('deleted_at', null)
      ->orderBy('posted_end_at', 'DESC')
      ->get();

    return Datatables::of($jobs)->make();
  }
}
