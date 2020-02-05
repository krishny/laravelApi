<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eventlog extends Model
{
    protected $fillable = [
        'email',
        'action'
    ];
}
