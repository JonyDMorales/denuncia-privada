@extends('layouts.app')
@include("navbar.navbar", ['title' => "Denuncias"])
@section('content')
@endsection
<div class="text-right"  style="margin: 30px">
    <h4 class="font-weight-bold"> Total: {{ $total }} </h4>
</div>
<div class="container">
    @foreach( $denuncias as $i => $denuncia )
        <div class="card card-body" id="{{ $total - $i }}">
            <div class="row">
                <div class="col-md-7">
                    <h6 class="text-right"> {{ $denuncia->created_at }} </h6>
                    <h3> {{ strtoupper($denuncia->tipo) }} </h3>
                    @if($denuncia->archivos)
                        @foreach($denuncia->archivos as $archivo)
                            @if(strpos($archivo, 'jpeg'))
                                <img class="rounded" src="https://s3.amazonaws.com/repofisca-nvirginia/{{ $archivo }}" height="200">
                            @elseif(strpos($archivo, 'mp4'))
                                <video class="rounded" height="200" controls>
                                    <source type="video/mp4" src="https://s3.amazonaws.com/repofisca-nvirginia/{{ $archivo }}">
                                </video>
                            @endif
                        @endforeach
                    @endif
                </div>
                <div class="col-md-5">
                    <h4> Descripción: <small> {{ $denuncia->descripcion }} </small> </h4>
                    <h4> Dirección: <small> {{ $denuncia->direccion }} </small> </h4>
                    <h4> Fecha de denuncia: <small> {{ $denuncia->fecha }} </small> </h4>
                    <h4> Estado: <small> {{ $denuncia->estado }} </small> </h4>
                    <h4> Municipio: <small> {{ $denuncia->municipio }} </small> </h4>
                    <h4> Colonia: <small> {{ $denuncia->colonia }} </small> </h4>
                    <h4> Código Postal: <small> {{ $denuncia->cp }} </small> </h4>
                </div>
            </div>
        </div>
    @endforeach
    <div style="padding-bottom: 30px"></div>
</div>
