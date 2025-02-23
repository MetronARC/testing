<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenderModel extends Model
{
    use HasFactory;

    protected $table      = 'tenders';
    protected $primaryKey = 'id';
    protected $guarded    = [];

    protected $maxDescription = 255;
    protected $maxText        = 65535;
    protected $phonePattern   = '/^\+?[0-9]{1,3}[-\s]?[0-9]{1,14}$/';

    public function validate($data)
    {
        $errors = [];

        if (empty($data['shipyard_id'])) {
            $errors['shipyard_id'] = 'Please select one of the options.';
        }

        if (empty($data['phone'])) {
            $errors['phone'] = 'This field is required.';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'This field is required.';
        }

        if (empty($data['title'])) {
            $errors['title'] = 'This field is required.';
        }

        if (empty($data['description'])) {
            $errors['description'] = 'This field is required.';
        }

        return $errors;
    }
}
