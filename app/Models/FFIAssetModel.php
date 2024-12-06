<?php

namespace App\Models;

use App\Models\FHRMSModel;
use Illuminate\Database\Eloquent\Model;

class FFIAssetModel extends Model
{
    public $table = 'assets_management';
    protected $fillable = [
        'employee_id',
        'asset_name',
        'asset_code',
        'issued_date',
        'returned_date',
        'damage_recover',
        'status',
    ];
    public function assets()
    {
        return $this->belongsTo(FHRMSModel::class, 'employee_id', 'id');
    }
}
