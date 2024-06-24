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
        'township',
        'register_date',
        'fatname',
        'port_id',
        'sn',
    ];

    public function newOrder(): BelongsTo
    {
        return $this->belongsTo(NewOrder::class, 'name');
    }

    public function port(): BelongsTo
    {
        return $this->belongsTo(Port::class, 'port_id');
    }

    public function fat(): BelongsTo
    {
        return $this->belongsTo(FatBox::class, 'fat_id');
    }
}
