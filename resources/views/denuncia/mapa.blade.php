@extends('layouts.app')
@include("navbar.navbar", ['title' => "Mapa de denuncias"])
@section('content')
    <div class="row">
        <div class="col-md-8" style="margin: 10px">
            <div id="map-canvas" style="width:100%; min-height:400px; height:80%;"></div>
        </div>
        <div class="col-md-3" style=" overflow-y: scroll; height: 560px;  ">
            @foreach( $denuncias as $i => $denuncia )
                <div class="card card-body" id="{{ $total - $i }}">
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
                    <h6> Descripción: <small> {{ $denuncia->descripcion }} </small> </h6>
                    <h6> Dirección: <small> {{ $denuncia->direccion }} </small> </h6>
                    <h6> Fecha de denuncia: <small> {{ $denuncia->fecha }} </small> </h6>
                    <h6> Estado: <small> {{ $denuncia->estado }} </small> </h6>
                    <h6> Municipio: <small> {{ $denuncia->municipio }} </small> </h6>
                    <h6> Colonia: <small> {{ $denuncia->colonia }} </small> </h6>
                    <h6> Código Postal: <small> {{ $denuncia->cp }} </small> </h6>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('javascript')
    <script language="javascript" type="text/javascript">
        var map;
        var Markers = [];
        var InitMarkers = [
            @foreach($denuncias as $denuncia)
                { lattitude: "{{ $denuncia->latitud  }}", longitude: "{{ $denuncia->longitud }}", title:"{{$denuncia->tipo}}" },
            @endforeach
        ];

        function setMarker(lattitude, longitude, title)
        {
            var markerEvent = new google.maps.Marker({
                position: new google.maps.LatLng(lattitude, longitude),
                map: map,
                title: title
            });
            var infoWindow = new google.maps.InfoWindow({
                content: title,
            });
            markerEvent.addListener('click', function(){
                infoWindow.open(map, markerEvent);
                map.setCenter(markerEvent.getPosition());
                map.setZoom(18);
            });
            return markerEvent;
        }

        function initMap() {
            map = new google.maps.Map(document.getElementById('map-canvas'), {
                center: { lat: 23.634501, lng: -102.552784 },
                zoom: 5
            });
            for(var i = 0; i < InitMarkers.length; i++)
            {
                Markers.push( setMarker(InitMarkers[i].lattitude, InitMarkers[i].longitude, InitMarkers[i].title) );
            }
        }
    </script>
    <!-- Mapa -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBiP1oJ0eKtfuh-fSBHUrKLqtrz0_MsX2U&callback=initMap" defer></script>
@endsection