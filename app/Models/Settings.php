<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'setting_name',
        'status',
        'changed_by',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
