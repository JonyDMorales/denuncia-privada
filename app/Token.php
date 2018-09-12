<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;

class Token extends Model {


    protected $connection = 'mongodenuncia';
    protected $collection = 'tokens';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha', 'clave'
    ];
    //Was protected
    public $timestamps = true;

    protected $dates = [
        'created_at',
        'updated_at'
    ];

}