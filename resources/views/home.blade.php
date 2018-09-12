@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Información General</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <h4>Nombre</h4>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                {{ Auth::user()->name }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <h4>E-mail</h4>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                {{ Auth::user()->email }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <h4>Perfil</h4>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                {{ Auth::user()->perfil }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @auth
        <!-- Panel de Acciones -->
        @if(Auth::User()->perfil == "admin")
            @include('admin.menu')
        @elseif( Auth::User()->perfil == "consultor")
            @include('consultor.menu')
        @elseif( Auth::User()->perfil == "filtro")
            @include('filtro.menu')
        @else
            @include('shared.partials.404', ['mensaje'=>'No se puede encontrar la página deseada'])
        @endif
    @endauth
@endsection
