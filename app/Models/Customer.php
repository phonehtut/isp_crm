<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'name',
        'register_date',
        'sn',
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

    public function port(): BelongsTo
    {
        return $this->belongsTo(Port::class, 'port_id');
    }

    public function fat(): BelongsTo
    {
        return $this->belongsTo(FatBox::class, 'fat_id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function township(): BelongsTo
    {
        return $this->belongsTo(Township::class, 'township_id');
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'customer_id');
    }
}
