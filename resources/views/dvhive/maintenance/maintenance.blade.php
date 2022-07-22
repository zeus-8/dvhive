@extends('adminlte::page')

@section('title', 'Mantenimiento')

@section('content_header')
    <h1>Mantenimiento</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="">Consulta de Alumno</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <form action="{{ url('maintenance/find') }}" method="post">
                                @csrf
                                <br>
                                <div class="input-group input-group-lg mb-3">
                                    <div class="input-group-prepend">
                                        <button type="submit" class="btn btn-outline-primary btn-lg">CONSULTAR</button>
                                    </div>
                                    <input type="text" name="document" id="document" class="form-control">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('dvhive.maintenance.modal')
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
@if ($modal > 0)
    @section('js')
        <script>  
            $('#staticBackdrop').modal('show')
        </script>
    @stop
@endif