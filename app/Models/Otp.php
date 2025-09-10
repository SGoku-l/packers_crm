<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = [
        'uid',
        'otp_code',
        'otp_expires_at'
    ];

    public $timestamps = true;
}
