<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewOrderTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'new_order_id',
        'type_id',
        'reason',
        'department_id',
        'fat_optical',
        'onu_optical',
        'priority',
        'status',
        'create_by',
    ];
}
