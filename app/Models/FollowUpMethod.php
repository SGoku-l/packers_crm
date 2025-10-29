<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUpMethod extends Model
{
    protected $fillable = [
        'method',
        'status',
        'type'
    ];
}
