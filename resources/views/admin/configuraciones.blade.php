@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Configuraciones</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('post') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6 col-md-6">
                                    <h4>Post en Facebook</h4>
                                </div>
                                <div class="col-sm-6 col-md-6">
                                    <label class="checkbox-inline">
                                        @if($configuraciones->post)
                                            <input type="radio" name="opcion[]" value="1" checked> <label> Encendido </label>
                                            <br>
                                            <input type="radio" name="opcion[]" value="2"> <label> Apagado </label>
                                        @else
                                            <input type="radio" name="opcion[]" value="1"> <label> Encendido </label>
                                            <br>
                                            <input type="radio" name="opcion[]" value="2" checked> <label> Apagado </label>
                                        @endif
                                    </label>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-outline-primary"> Aceptar </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('agregar') }}">
                            @csrf
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
                                <button type="submit" class="btn btn-outline-success"> Agregar </button>
                            </div>
                        </form>
                    </div>
                    @if($configuraciones->fields)
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Campos</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($configuraciones->fields as $campo )
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $campo }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection