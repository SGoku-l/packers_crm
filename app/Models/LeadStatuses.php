<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadStatuses extends Model
{
    protected $fillable = [
        'lead_status',
        'status',
        'type'
    ];
}
