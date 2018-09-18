<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model;

class Configuraciones extends Model {


    protected $connection = 'mongodenuncia';
    protected $collection = 'configuraciones';

    protected $fillable = [
        'post', 'fields'
    ];
    //Was protected
    public $timestamps = true;

    protected $dates = [ ];

}