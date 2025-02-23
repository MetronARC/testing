<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobModel extends Model {
    
    use HasFactory; 

    protected $table      = 'jobs';
    protected $primaryKey = 'id';
    protected $guarded    = [];

    protected $maxDescription = 255;
    protected $maxText        = 65535;

    public function validate($data)
    {
        $errors = [];

        if (empty($data['position'])) {
            $errors['position'] = 'This field is required.';
        } elseif (mb_strlen($data['position']) > $this->maxDescription) {
            $errors['position'] = 'The maximum length for this field is ' . $this->maxDescription . ' characters.';
        }

        if (empty($data['company'])) {
            $errors['company'] = 'This field is required.';
        } elseif (mb_strlen($data['company']) > $this->maxDescription) {
            $errors['company'] = 'The maximum length for this field is ' . $this->maxDescription . ' characters.';
        }

        if (empty($data['responsible'])) {
            $errors['responsible'] = 'This field is required.';
        } elseif (mb_strlen($data['responsible']) > $this->maxText) {
            $errors['responsible'] = 'The maximum length for this field is ' . $this->maxText . ' characters.';
        }

        if (empty($data['requirement'])) {
            $errors['requirement'] = 'This field is required.';
        } elseif (mb_strlen($data['requirement']) > $this->maxText) {
            $errors['requirement'] = 'The maximum length for this field is ' . $this->maxText . ' characters.';
        }

        if (!empty($data['posted_start_at']) && !empty($data['posted_end_at']) && strtotime($data['posted_end_at']) < strtotime($data['posted_start_at'])) {
            $errors['posted_start_at'] = 'Date is invalid. Start date must be smaller than end date.';
        }

        return $errors;
    }
}
