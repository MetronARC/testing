<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyPolicyModel extends Model
{
    use HasFactory;

    protected $table      = 'privacies';
    protected $primaryKey = 'id';
    protected $guarded    = [];
}
