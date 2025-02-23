<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShipyardModel extends Model
{
    use HasFactory;

    protected $table      = 'user_shipyards';
    protected $primaryKey = 'id';
    protected $guarded    = [];

    protected $maxText = 65535;
}
