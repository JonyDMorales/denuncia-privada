<?php

namespace App;
use Jenssegers\Mongodb\Eloquent\Model;
class User extends Model
{
    protected $connection = 'mongousr';
    protected $table = 'users';
    protected $fillable = [
        'name', 'email', 'password'
    ];
    protected $hidden = [
        'api-token','password'
    ];
    public $timestamps = true;
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
