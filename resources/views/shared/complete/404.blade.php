@extends('layouts.app')
@section('title') ERROR @endsection
@section('content')
    <div class="row">
        <div class="col-sm-8 col-md-8 col-lg-8 col-md-offset-2 col-lg-offset-2 col-sm-offset-2">
            <div class="panel panel-danger">
                <div class="panel-body">
                    <div class="text-center text-danger">
                        <i class="fa fa-5x fa-ban"></i>
                    </div>
                    <h1 class="text-center text-danger">
                        404
                        <br/>
                        <small>No encontrado</small>
                    </h1>
                    <p class="text-center text-muted">{{$mensaje}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection