@extends('layouts.app')
@include("navbar.navbar", ['title' => "Denuncia"])
@section('content')
    <form id="denuncia" method="post" class="margenes">
        <h1 class="text-center" style="margin: 25px">Formula tu denuncia</h1>
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        {{ csrf_field() }}
                        <input name="usuario" type="hidden" id="usuario" value="publico">
                        <input name="nosotros" type="hidden" id="nosotros" value="false">
                        <input name="latitud" type="hidden" id="latitud">
                        <input name="longitud" type="hidden" id="longitud">
                        <input name="j" type="hidden" id="j">
                        <div class="form-group">
                            <label>Tipo de denuncia: <span style="color: red">*</span></label>
                            <select class="form-control" name="tipo" id="tipo" required>
                                <option value="">Selecciona:</option>
                                <option value="Violencia">Violencia</option>
                                <option value="Acarreo o compra de votos">Acarreo o compra de votos</option>
                                <option value="Problemas en casilla">Problemas en casilla</option>
                                <option value="Condicionamiento del voto">Condicionamiento del voto</option>
                                <option value="Otros">Otros</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Fecha: <span style="color: red">*</span></label>
                            <input type="datetime-local" class="form-control form_datetime" name="fecha" id="fecha" required>
                        </div>
                        <div class="form-group">
                            <label>Código Postal: <span style="color: red">*</span></label>
                            <input type="text" class="form-control" placeholder="CP" name="cp" id="cp" required>
                        </div>
                        <div class="form-group">
                            <label>Estado: <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="estado" value="CDMX" id="estado" disabled="disabled" required>
                        </div>
                        <div class="form-group">
                            <label>Municipio: <span style="color: red">*</span></label>
                            <input type="text" class="form-control" name="municipio" value="CDMX" id="municipio" disabled="disabled" required>
                        </div>
                        <div class="form-group">
                            <label>Colonia: <span style="color: red">*</span></label>
                            <select class="form-control" name="colonia" id="colonia" required>
                                <option value="CDMX"> Selecciona:  </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Detalles del lugar: <span style="color: red">*</span></label>
                            <input type="text" class="form-control" placeholder="Casilla, Calle, número, referencias" name="direccion" id="direccion" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">

                <div class="form-group">
                    <label>Descripción de los hechos: <span style="color: red">*</span></label>
                    <textarea class="form-control" name="descripcion" id="descripcion" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label>Foto/Video:</label>
                    <input type="file" id="archivos" name="archivos" class="form-control" required>
                </div>
                <div class="form-check">
                    <input type="checkbox" id="anonimo" class="form-check-input" checked>
                    <label class="form-check-label"> Anónimo</label>
                </div>
                <div class="form-group" id="div-nombre">
                    <label>Nombre: </label>
                    <input type="text" class="form-control" placeholder="Nombre completo" name="nombre" id="nombre">
                </div>
                <div class="form-group" id="div-email">
                    <label>Email: </label>
                    <input type="email" class="form-control" placeholder="Email"  name="email" id="email">
                </div>
                <div class="form-group" id="div-telefono">
                    <label>Teléfono: </label>
                    <input type="text" class="form-control" placeholder="Teléfono"  name="telefono" id="telefono">
                </div>
                <div id="recaptcha" ></div>
                <div class="form-group" style="margin-top: 10px">
                    <button id="boton" type="submit" class="btn btn-outline-primary btn-block">Enviar</button>
                </div>
            </div>
        </div>
    </form>

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
                                Denuncia enviada.
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

            function inicio() {
                $.get('{{ route('tokens') }}', function () {})
                    .done(function (res) {
                        $('#j').val(res.from);
                    })
                    .fail(function (res) {
                        $('#j').val(null);
                    });
            };
            inicio();

            $('#boton').hide();

            if(navigator.geolocation){
                navigator.geolocation.getCurrentPosition(function(position) {
                    $('#latitud').val(position.coords.latitude);
                    $('#longitud').val(position.coords.longitude);
                });
            } else {
                $('#latitud').val('23.634501');
                $('#longitud').val('-102.552784');
            }

            $("#div-nombre").hide();
            $("#div-email").hide();
            $("#div-telefono").hide();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('#anonimo').change(function() {
                if($(this).is(":checked")) {
                    $("#div-nombre").hide();
                    $("#div-email").hide();
                    $("#div-telefono").hide();
                } else {
                    $("#div-nombre").show();
                    $("#div-email").show();
                    $("#div-telefono").show();
                }
            });

            $('.btn-outline-primary').on('click', function (e) {
                e.preventDefault();

                var usuario = $("#usuario").val();
                var nosotros = $("#nosotros").val();
                var latitud = $("#latitud").val();
                var longitud = $("#longitud").val();
                var tipo = $("#tipo").val();
                var fecha = $("#fecha").val();
                var cp = $("#cp").val();
                var estado = $("#estado").val();
                var municipio = $("#municipio").val();
                var colonia = $("#colonia").val();
                var direccion = $("#direccion").val();
                var descripcion = $("#descripcion").val();
                var token = $("#j").val();

                if(usuario && nosotros && latitud && longitud && tipo && fecha && cp && estado && municipio && colonia && direccion && descripcion){
                    var form = new FormData($("#denuncia")[0]);
                    $("#modalLoading").modal('show');
                    form.append('usuario',usuario);
                    form.append('nosotros',nosotros);
                    form.append('latitud',latitud);
                    form.append('longitud',longitud);
                    form.append('tipo',tipo);
                    form.append('fecha',fecha);
                    form.append('cp',cp);
                    form.append('estado',estado);
                    form.append('municipio',municipio);
                    form.append('colonia',colonia);
                    form.append('direccion',direccion);
                    form.append('descripcion',descripcion);
                    form.append('token', token);

                    /*console.log(usuario);
                    console.log(nosotros);
                    console.log(latitud);
                    console.log(longitud);
                    console.log(tipo);
                    console.log(fecha);
                    console.log(cp);
                    console.log(estado);
                    console.log(municipio);
                    console.log(colonia);
                    console.log(direccion);
                    console.log(descripcion);*/

                    $.ajax({
                        type: 'POST',
                        url: '{{route('insertar')}}',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        enctype: 'multipart/form-data',
                        data: form,
                        processData: false,
                        contentType: false,
                        cache: false,
                        timeout: 600000,
                        success: function (res) {
                            $("#modalLoading").modal('hide');
                            $("#modalSuccess").modal('show');
                        },
                        error: function (res) {
                            console.log(res);
                            $("#modalLoading").modal('hide');
                            $("#modalFail #errmess").text("No se pudo agregar tu denuncia, intentalo nuevamente");
                            $("#modalFail").modal('show');
                        }
                    });
                } else {
                    $("#modalFail #errmess").text("Por favor, llena todos los campos requeridos");
                    $("#modalFail").modal('show');
                }
            });

            grecaptcha.render('recaptcha', {
                'sitekey' : '{{ env('GOOGLE_RECAPTCHA_KEY') }}',
                'callback' : function(response) {
                    if (response) {
                        $('#boton').show();
                    }else {
                        $("#modalFail #errmess").text("Por favor, recarga la página");
                        $("#modalFail").modal('show');
                    }
                },
                'theme' : 'light'
            });
        });
    </script>
    <script src="https://www.google.com/recaptcha/api.js"
            async defer>
    </script>
@endsection