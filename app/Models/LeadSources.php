<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadSources extends Model
{
    protected $fillable = [
        'source_name',
        'status',
        'type'
    ];
}
