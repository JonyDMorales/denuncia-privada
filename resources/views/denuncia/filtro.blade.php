@extends('layouts.app')
@include("navbar.navbar", ['title' => "Filtro de denuncias"])
@section('content')
    <div class="text-right"  style="margin: 30px">
            <h4 class="font-weight-bold"> Total: {{ $total }} </h4>
    </div>
    <div class="container">
        {{ csrf_field() }}
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @foreach( $denuncias as $i => $denuncia )
            <div class="card card-body" id="{{ $denuncia ->id }}">
                <div class="row">
                    <div class="col-md-4">
                        <h4> Descripción: <small> {{ $denuncia->descripcion }} </small> </h4>
                        <h4> Dirección: <small> {{ $denuncia->direccion }} </small> </h4>
                        <h4> Fecha de denuncia: <small> {{ $denuncia->fecha }} </small> </h4>
                        <h4> Estado: <small> {{ $denuncia->estado }} </small> </h4>
                        <h4> Municipio: <small> {{ $denuncia->municipio }} </small> </h4>
                        <h4> Colonia: <small> {{ $denuncia->colonia }} </small> </h4>
                        <h4> Código Postal: <small> {{ $denuncia->cp }} </small> </h4>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-right"> {{ $denuncia->created_at }} </h6>
                        <h1> {{ strtoupper($denuncia->tipo) }} </h1>
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
                    <div class="col-md-2">
                        <h6 class="text-right"> {{ $total - $i }} </h6>
                        <button mongo="{{ $denuncia ->id }}" class="btn btn-outline-primary btn-block">Aprobar</button>
                        <button mongo="{{ $denuncia ->id }}" class="btn btn-outline-danger btn-block" style="margin-top: 30%">Rechazar</button>
                    </div>
                </div>
            </div>
        @endforeach
        <div style="padding-bottom: 30px"></div>
    </div>

    <div class="modal fade" id="modalLoading" tabindex="-1" role="dialog" aria-labelledby="tituloLoading">
        <div class="modal-dialog" role="document">
            <div class="modal-content text-center">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-10 col-md-offset-1 text-center">
                            <i class="fa fa-refresh fa-spin fa-4x fa-fw"></i>
                            <h4 class="modal-title" id="tituloLoading">Cargando ...</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalFail" tabindex="-1" role="dialog" aria-labelledby="tituloFail">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="text-right close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-10 col-md-offset-1 text-center text-danger">
                            <i class="fa fa-ban fa-4x fa-fw"></i>
                            <h3>
                                Ocurrió un error inesperado.<br/>
                                <small id="errmess"></small>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalSuccess" tabindex="-1" role="dialog" aria-labelledby="tituloOk">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <button type="button" class="text-right close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-10 col-md-offset-1 text-center text-success">
                            <i class="fa fa-check fa-4x fa-fw"></i>
                            <h3>
                                Denuncia filtrada.
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script language="javascript" type="text/javascript">

        $(document).ready(function() {
            $("#modalLoading").modal({
                keyboard:false,
                backdrop:'static',
                show:false
            });
            $("#modalFail").modal({
                show:false
            });
            $("#modalSuccess").modal({
                show:false
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.btn-outline-primary').on('click', function (e) {
                e.preventDefault();
                var id =  $(this).attr('mongo');
                if(id){
                    $("#modalLoading").modal('show');
                    $.post('{{route('aprobar')}}', {id: id})
                        .done(function (res) {
                            $('#'+ id).hide();
                            $("#modalLoading").modal('hide');
                            $("#modalSuccess").modal('show');
                        })
                        .fail(function (res) {
                            $('#'+ id).hide();
                            $("#modalLoading").modal('hide');
                            $("#modalFail #errmess").text("Ya se opero esa denuncia");
                            $("#modalFail").modal('show');
                        });
                } else {
                    $('#'+ id).hide();
                    $("#modalFail #errmess").text("Ya se opero esa denuncia");
                    $("#modalFail").modal('show');
                }
            });

            $('.btn-outline-danger').on('click', function (e) {
                e.preventDefault();
                var id = $(this).attr('mongo');
                if(id){
                    $("#modalLoading").modal('show');
                    $.post('{{route('rechazar')}}', {id: id})
                        .done(function (res) {
                            $('#'+ id).hide();
                            $("#modalLoading").modal('hide');
                            $("#modalSuccess").modal('show');
                        })
                        .fail(function (res) {
                            $('#'+ id).hide();
                            $("#modalLoading").modal('hide');
                            $("#modalFail #errmess").text("Ya se opero esa denuncia");
                            $("#modalFail").modal('show');
                        });
                } else {
                    $('#'+ id).hide();
                    $("#modalFail #errmess").text("Ya se opero esa denuncia");
                    $("#modalFail").modal('show');
                }
            });
        });
    </script>
@endsection