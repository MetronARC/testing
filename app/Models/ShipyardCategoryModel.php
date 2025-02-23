<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipyardCategoryModel extends Model
{
    use HasFactory;

    protected $table      = 'shipyard_categories';
    protected $primaryKey = 'id';
    protected $guarded    = [];

    protected $maxDescription = 255;
    protected $maxText        = 65535;

    public function getAllCategories()
    {
        $result = ShipyardCategoryModel::selectRaw('UPPER(name) name')
            ->where('deleted_at', null)
            ->get();

        $returnData = [];

        foreach ($result as $_val) {
            $returnData[] = $_val->name;
        }

        return $returnData;
    }
}
