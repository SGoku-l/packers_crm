<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'user_agent',
        'device_name',
        'login_otp_verifi_status',
        'logged_in_at',
        'logged_out_at'
    ];

    public function user()  {

        return $this->belongsTo(User::class);

    }
}
