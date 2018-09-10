@extends('layouts.app')
@section('title') Operación exitosa @endsection
@section('content')
    <div class="row">
        <div class="col-sm-8 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2 col-sm-offset-2">
            <div class="panel panel-success">
                <div class="panel-body">
                    <div class="text-center text-success">
                        <i class="fa fa-5x fa-check"></i>
                    </div>
                    <h1 class="text-center text-success">
                        200
                        <br/>
                        <small>Éxito</small>
                    </h1>
                    <p class="text-center text-muted">{{$mensaje}}</p>
                    <p class="center-block">
                        <a class="btn btn-default" href="">Regresar</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection