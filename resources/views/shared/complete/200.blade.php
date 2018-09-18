@extends('layouts.app')
@section('title') Operación exitosa @endsection
@section('content')
    <div class="row justify-content-center">
        <div class="col-sm-8 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2 col-sm-offset-2">
            <div class="card">
                <div class="card-body">
                    <div class="text-center text-success">
                        <i class="fa fa-5x fa-check"></i>
                    </div>
                    <h1 class="text-center text-success">
                        200
                        <br/>
                        <small>Éxito</small>
                    </h1>
                    <p class="text-center text-muted">{{$mensaje}}</p>
                    <p class="text-center">
                        <a class="btn btn-success" href="{{ route( $destino ) }}">Regresar</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection