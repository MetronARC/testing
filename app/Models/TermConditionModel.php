<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TermConditionModel extends Model
{
    use HasFactory;

    protected $table      = 'terms';
    protected $primaryKey = 'id';
    protected $guarded    = [];
}
