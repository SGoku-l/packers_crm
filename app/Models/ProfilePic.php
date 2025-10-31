<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilePic extends Model
{
    protected $fillable = [
        'uid',
        'profile_pic'
    ];

     public function user()
    {
        return $this->belongsTo(User::class, 'uid');
    }

}
