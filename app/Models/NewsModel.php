<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class NewsModel extends Model
{
  use HasFactory;

  protected $table      = 'news';
  protected $primaryKey = 'id';
  protected $guarded    = [];

  protected $maxDescription = 255;
  protected $maxText        = 65535;
  protected $phonePattern   = '/^\+?[0-9]{1,3}[-\s]?[0-9]{1,14}$/';

  protected $firstIndex = 1;
  protected $totalItemPerPage = 10;

  public function validate($data)
  {
    $errors = [];

    if (empty($data['title'])) {
      $errors['title'] = 'This field is required.';
    }

    if (empty($data['description'])) {
      $errors['description'] = 'This field is required.';
    }

    if (empty($data['category'])) {
      $errors['category'] = 'This field is required.';
    }

    if (empty($data['start_date'])) {
      $errors['start_date'] = 'This field is required.';
    }

    return $errors;
  }

  public function getFirstNews()
  {
    $result = NewsModel::where('deleted_at', null)
      ->where('start_date', '<=', DB::raw('NOW()'))
      ->where('status', 'publish')
      ->orderBy('start_date', 'DESC')
      ->orderBy('created_at', 'DESC')
      ->first()
      ->toArray();

    return $result;
  }

  public function getDetail($id)
  {
    $result = NewsModel::where('deleted_at', null)
      ->where('start_date', '<=', DB::raw('NOW()'))
      ->where('status', 'publish')
      ->where('id', $id)
      ->first()
      ->toArray();

    return $result;
  }

  public function getNews($page = 1)
  {
    $offset = ($page * $this->totalItemPerPage) - $this->totalItemPerPage + $this->firstIndex;
    $limit  = $this->totalItemPerPage;

    $result = NewsModel::where('deleted_at', null)
      ->where('start_date', '<=', DB::raw('NOW()'))
      ->where('status', 'publish')
      ->orderBy('start_date', 'DESC')
      ->orderBy('created_at', 'DESC')
      ->limit($limit)
      ->offset($offset)
      ->get();

    return $result ? $result->toArray() : [];
  }

  public function getPopular($total = 5)
  {
    $result = NewsModel::where('deleted_at', null)
      ->where('start_date', '<=', DB::raw('NOW()'))
      ->where('status', 'publish')
      ->orderBy('total_view', 'DESC')
      ->limit($total)
      ->get();

    return $result ? $result->toArray() : [];
  }
}
