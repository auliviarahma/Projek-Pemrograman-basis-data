<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'user';
    protected $primaryKey = 'iduser';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
        'idrole',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'idrole', 'idrole');
    }
}