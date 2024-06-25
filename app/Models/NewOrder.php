<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'nrc_front',
        'nrc_back',
        'plan_id',
        'lat_long',
        'status',
        'start_cable',
        'end_cable',
        'total_cable',
        'fat_optical',
        'cus_res_optical',
        'onu_optical',
        'township_id',
        'plan_id',
        'fat_id',
        'port_id',
        'create_user',
    ];

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
