<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiUser extends Model
{
    protected $fillable = [
        'first_name',
        'sur_name',
        'agentId',
        'email',
        'login_name',
        'password',
        'operatorLevel',
        'status',
    ];
}
