<div class="row justify-content-center" style="padding: 1%;">
    <!--<div class="col-md-8" style="color: white;">-->
    <div class="col-lg-2 col-md-4 col-sm-6 col-md-offset-1">
        <div class="panel panel-primary">
            <div class="panel-heading">Registrar Usuarios</div>
            <div class="panel-body text-center">
                <a class="btn btn-lg btn-primary" href="{{ route('registrar') }}">
                    <i class="fa fa-user fa-3x pull-left"></i> Usuarios
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="panel panel-success">
            <div class="panel-heading">Ver Denuncias</div>
            <div class="panel-body text-center">
                <a class="btn btn-lg btn-success" href="{{ route('denuncias') }}">
                    <i class="fa fa-book fa-3x pull-left"></i> Denuncias
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="panel panel-danger">
            <div class="panel-heading">Ver Mapa</div>
            <div class="panel-body text-center">
                <a class="btn btn-lg btn-danger" href="{{ route('mapa') }}">
                    <i class="fa fa-map-marker fa-3x pull-left"></i> mapa
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="panel panel-primary">
            <div class="panel-heading">Configiraciones</div>
            <div class="panel-body text-center">
                <a class="btn btn-lg btn-primary" href="{{ route('configuraciones') }}">
                    <i class="fa fa-cog fa-3x pull-left"></i> configurar
                </a>
            </div>
        </div>
    </div>
</div>

@section('bottom_javascript')
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
@endsection
