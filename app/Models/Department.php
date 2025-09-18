<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'department_name',
        'remark',
        'view',
        'edit',
        'delete',
        'create',
        'menu_access',
        'modified_by',
        'modified_at'
    ];

    protected $casts = [
        'menu_access' => 'array',
        'view' => 'boolean',
        'edit' => 'boolean',
        'delete' => 'boolean',
        'create' => 'boolean',
    ];

    public function user(){

       return $this->belongsTo(User::class,'modified_by');

    }
}
