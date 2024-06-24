<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FatBox extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_fat_box_port')
                    ->withPivot('port_id')
                    ->withTimestamps();
    }

    public function ports(): BelongsToMany
    {
        return $this->belongsToMany(Port::class, 'fats_ports', 'fat_id', 'port_id');
    }
}
