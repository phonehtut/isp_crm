<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parallax\FilamentComments\Models\Traits\HasFilamentComments;

class Ticket extends Model
{
    use HasFactory;
    use HasFilamentComments;

    protected $fillable = [
        'title',
        'customer_id',
        'type_id',
        'reason',
        'department_id',
        'priority',
        'status',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function newOrder(): BelongsTo
    {
        return $this->belongsTo(NewOrder::class, 'new_order_id');
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
