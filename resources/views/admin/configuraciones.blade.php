@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Configuraciones</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <h4>Post en Facebook</h4>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <label class="checkbox-inline">
                                    <input type="checkbox" data-toggle="toggle">
                                </label>
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-outline-primary"> Aceptar</button>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <h4>Agregar campo</h4>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <label class="input-group">
                                    <input type="text" class="form-control" name="campo">
                                </label>
                            </div>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-outline-success"> Agregar </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection