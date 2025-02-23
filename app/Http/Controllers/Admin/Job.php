<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\JobCategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

use App\Models\JobModel;

use Yajra\DataTables\DataTables;

/**
 * Controller
 * 
 * @author Saka Mahendra Arioka
 *         saka@sakarioka.com
 *         +6285338845666
 */
class Job extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->data['title'] = 'Job';
    }

    // method index (default)
    public function index(Request $request)
    {
        // set view
        return view('admin/job.v_index', $this->data);
    }

    public function datatable(Request $request)
    {
        $jobs = JobModel::where('deleted_at', null)
            ->orderBy('slug', 'ASC')
            ->get();

        foreach ($jobs as $key => $val) {
            if ($val->status == 'publish') {
                if (!empty($val->posted_start_at) && strtotime($val->posted_start_at) > strtotime('now')) {
                    $jobs[$key]->status = 'pending';
                } elseif (!empty($val->posted_end_at) && strtotime($val->posted_end_at) < strtotime('now')) {
                    $jobs[$key]->status = 'expired';
                }
            }

            $jobs[$key]->status = ucwords($jobs[$key]->status);
        }

        // dd($jobs);

        return Datatables::of($jobs)
            ->rawColumns(['responsible', 'requirement'])
            ->make();
    }

    public function add(Request $request)
    {
        $this->data['title'] .= ' Add New';

        $mJob = new JobModel();

        if ($request->post()) {
            $_company = $request->post('company');
            $_position = $request->post('position');
            $_slug = Str::slug(trim($_company . ' ' . $_position));

            $inputData = [
                'slug'            => $_slug,
                'company'         => strtoupper($_company),
                'position'        => strtoupper($_position),
                'responsible'     => $request->post('responsible'),
                'requirement'     => $request->post('requirement'),
                'posted_start_at' => $request->post('posted_start_at'),
                'posted_end_at'   => $request->post('posted_end_at'),
                'status'          => $request->post('status'),
                'created_by'      => $this->data['auth_data']['id'],
                'updated_by'      => $this->data['auth_data']['id'],
            ];

            $errors = $mJob->validate($inputData);

            if (empty($errors)) {
                JobModel::create($inputData);

                return redirect()->route('job.jobIndex')->with('__success', 'Data Added.');
            }

            $this->data['errors'] = $errors;
        }

        return view('admin/job.v_add', $this->data);
    }

    public function detail(Request $request, $id)
    {
        $this->data['title'] .= ' Detail';

        $mJob = new JobModel();

        $job = JobModel::where('deleted_at', null)
            ->where('id', $id)
            ->first()
            ->toArray();

        if (empty($job)) {
            abort(404);
        }

        if ($request->post()) {
            $_company = $request->post('company');
            $_position = $request->post('position');
            $_slug = Str::slug(trim($_company . ' ' . $_position));

            $inputData = [
                'slug'            => $_slug,
                'company'         => strtoupper($_company),
                'position'        => strtoupper($_position),
                'responsible'     => $request->post('responsible'),
                'requirement'     => $request->post('requirement'),
                'posted_start_at' => $request->post('posted_start_at'),
                'posted_end_at'   => $request->post('posted_end_at'),
                'status'          => $request->post('status'),
                'updated_by'      => $this->data['auth_data']['id'],
            ];

            $errors = $mJob->validate($inputData);

            if (empty($errors)) {
                JobModel::where([
                    'id' => $id
                ])->update($inputData);

                return redirect()->route('job.jobIndex')->with('__success', 'Data Updated.');
            }

            $this->data['errors'] = $errors;
        }

        $this->data['job'] = $job;

        return view('admin/job.v_detail', $this->data);
    }

    public function delete(Request $request, $id)
    {
        JobModel::where([
            'id' => $id
        ])->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => $this->data['auth_data']['id'],
        ]);

        return redirect()->route('job.jobIndex')->with('__status', 'Data Deleted.');
    }
}
