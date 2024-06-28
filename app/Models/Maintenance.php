<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'issues_at',
        'ticket_id',
        'customer_id',
        'cc_remark',
        'department_id',
        'noc_remark',
        'noc_engineer',
        'finish_noc_engineer',
        'status',
        'site_engineer',
        'finish_at',
        'duration',
        'issues',
        'fault_point_id',
        'onu',
        'adapter',
        'drop_cable',
        'patch_cord_apc',
        'patch_cord_upc',
        'pigtail_apc',
        'pigtail_upc',
        'sleeve',
        'sleeve_closure',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function noc(): BelongsTo
    {
        return $this->belongsTo(User::class, 'noc_engineer');
    }

    public function finishNoc(): BelongsTo
    {
        return $this->belongsTo(User::class, 'finish_noc_engineer');
    }

    public function faultPoint(): BelongsTo
    {
        return $this->belongsTo(FaultPoint::class,'fault_point_id');
    }

}
