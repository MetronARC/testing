<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipyardModel extends Model
{
    use HasFactory;

    protected $table      = 'shipyards';
    protected $primaryKey = 'id';
    protected $guarded    = [];

    protected $maxDescription = 255;
    protected $maxText        = 65535;
    protected $phonePattern   = '/^\+?[0-9]{1,3}[-\s]?[0-9]{1,14}$/';

    public function validate($data)
    {
        $errors = [];

        if (empty($data['type'])) {
            $errors['type'] = 'This field is required.';
        } elseif (mb_strlen($data['type']) > $this->maxDescription) {
            $errors['type'] = 'The maximum length for this field is ' . $this->maxDescription . ' characters.';
        } elseif (!array_key_exists($data['type'], config('custom')['type'])) {
            $errors['type'] = 'The option value is invalid';
        }

        if (empty($data['name'])) {
            $errors['name'] = 'This field is required.';
        } elseif (mb_strlen($data['name']) > $this->maxDescription) {
            $errors['name'] = 'The maximum length for this field is ' . $this->maxDescription . ' characters.';
        }

        if (!empty($data['other_name']) && mb_strlen($data['other_name']) > $this->maxDescription) {
            $errors['other_name'] = 'The maximum length for this field is ' . $this->maxDescription . ' characters.';
        }

        if (!empty($data['listing_number']) && mb_strlen($data['listing_number']) > $this->maxDescription) {
            $errors['listing_number'] = 'The maximum length for this field is ' . $this->maxDescription . ' characters.';
        }

        if (empty($data['location'])) {
            $errors['location'] = 'This field is required.';
        } elseif (mb_strlen($data['location']) > $this->maxDescription) {
            $errors['location'] = 'The maximum length for this field is ' . $this->maxDescription . ' characters.';
        }

        if (empty($data['category'])) {
            $errors['category'] = 'This field is required.';
        } elseif (mb_strlen($data['category']) > $this->maxDescription) {
            $errors['category'] = 'The maximum length for this field is ' . $this->maxDescription . ' characters.';
        }

        if (!empty($data['website_url'])) {
            if (isValidURL($data['website_url'])) {
                $errors['website_url'] = 'Phone number format is invalid.';
            } elseif (mb_strlen($data['website_url']) > $this->maxDescription) {
                $errors['website_url'] = 'The maximum length for this field is ' . $this->maxDescription . ' characters.';
            }
        }

        if (!empty($data['established_year']) && !isValidYear($data['established_year'])) {
            $errors['established_year'] = 'Year format is invalid';
        }

        if (!empty($data['group']) && mb_strlen($data['group']) > $this->maxDescription) {
            $errors['group'] = 'The maximum length for this field is ' . $this->maxDescription . ' characters.';
        }

        return $errors;
    }

    public function getLocations()
    {
        $result = ShipyardModel::select('location')
            ->where('deleted_at', null)
            ->groupBy('location')
            ->get();

        $returnData = [];

        foreach ($result as $_val) {
            $returnData[] = $_val->location;
        }

        return $returnData;
    }
}
