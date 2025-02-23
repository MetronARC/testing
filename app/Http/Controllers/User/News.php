<?php

namespace App\Http\Controllers\User;

// use App\User;
use App\Http\Controllers\User\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\NewsModel;

class News extends Controller
{
  public function index(Request $request, $lang = '')
  {
    $mNews = new NewsModel();

    $this->data['firstNews']   = $mNews->getFirstNews();
    $this->data['news']        = $mNews->getNews();
    $this->data['popularNews'] = $mNews->getPopular();

    return view('user.news.v_index', $this->data);
  }

  public function detail(Request $request, $year, $month, $date, $id, $slug)
  {
    $mNews = new NewsModel();

    $this->data['news']        = $mNews->getDetail($id);
    $this->data['popularNews'] = $mNews->getPopular();

    return view('user.news.v_detail', $this->data);
  }
}
