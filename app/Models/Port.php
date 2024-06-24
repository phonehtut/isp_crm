<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Port extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_fat_box_port')
                    ->withPivot('fat_box_id')
                    ->withTimestamps();
    }

    public function fat_boxes(): BelongsToMany
    {
        return $this->belongsToMany(FatBox::class, 'fats_ports', 'port_id', 'fat_id');
    }
}
