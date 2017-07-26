<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'name', 'username', 'password', 'email',
    ];
    
    protected $hidden = [
        'password', 'remember_token', 'created_at', 'updated_at', 'deleted_at',
    ];
}
