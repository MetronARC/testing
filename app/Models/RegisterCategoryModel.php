<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterCategoryModel extends Model
{
    use HasFactory;

    protected $table      = 'register_categories';
    protected $primaryKey = 'id';
    protected $guarded    = [];
}
