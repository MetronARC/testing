<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table      = 'users';
    protected $primaryKey = 'id';
    protected $guarded    = [];

    protected $maxText = 65535;

    public function validateRegister($data)
    {
        $errors = [];

        if ($data['category'] == 'shipyard') {
            if (empty($data['shipyard_id'])) {
                $errors['shipyard_id'] = 'Please select one of the options.';
            }
        } else {
            if (empty($data['company_name'])) {
                $errors['company_name'] = 'This field is required.';
            } elseif (mb_strlen($data['company_name']) > $this->maxText) {
                $errors['company_name'] = 'The maximum length for this field is ' . $this->maxText . ' characters.';
            }
        }

        if (empty($data['name'])) {
            $errors['name'] = 'This field is required.';
        } elseif (mb_strlen($data['name']) > $this->maxText) {
            $errors['name'] = 'The maximum length for this field is ' . $this->maxText . ' characters.';
        }

        if (empty($data['position'])) {
            $errors['position'] = 'This field is required.';
        } elseif (mb_strlen($data['position']) > $this->maxText) {
            $errors['position'] = 'The maximum length for this field is ' . $this->maxText . ' characters.';
        }

        if (empty($data['phone'])) {
            $errors['phone'] = 'This field is required.';
        } elseif (mb_strlen($data['phone']) > $this->maxText) {
            $errors['phone'] = 'The maximum length for this field is ' . $this->maxText . ' characters.';
        }

        if (empty($data['email'])) {
            $errors['email'] = 'This field is required.';
        } elseif (mb_strlen($data['email']) > $this->maxText) {
            $errors['email'] = 'The maximum length for this field is ' . $this->maxText . ' characters.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email address format is invalid.';
        } else {
            $user = UserModel::where('email', $data['email'])
                ->where('deleted_at', null)
                ->first();
            
            if ($user) {
                $errors['email'] = 'Email address already registered.';
            }
        }

        return $errors;
    }
}
