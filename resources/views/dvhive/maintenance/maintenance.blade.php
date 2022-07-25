@extends('adminlte::page')

@section('title', 'Mantenimiento')

@section('content_header')
    <h1>Mantenimiento</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10 offset-md-1">
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
                    </div><br><br><br>
                    <div class="row">
                        <div class="col-md-10 offset-1">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">ID</th>
                                        <th scope="col">Carrera</th>
                                        <th scope="col">Nombre</th>
                                        {{--  
                                        <th scope="col">TURNO ANTERIOR</th>
                                        <th scope="col">AÑO ANTERIOR</th>
                                        <th scope="col">INICIO ANTERIOR</th>
                                        <th scope="col">MODALIDAD ANTERIOR</th>
                                        <th scope="col">Turno </th>
                                        <th scope="col">Año </th>
                                        <th scope="col">Inicio </th>
                                        <th scope="col">Modalidad </th>--}}
                                        <th scope="col">Observacion</th>
                                        <th scope="col">Modificado</th>
                                        <th scope="col">Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($incidence as $in  )
                                        <tr>
                                            <td>{{ $in->id }}</td>
                                            <td>{{ $in->id_person }}</td>
                                            <td>{{ $in->id_career }}</td>
                                            <td>name</td>
                                            <td>{{ $in->observacion }}</td>
                                            <td>{{ $in->user }}</td>
                                            <td>
                                                 <div class="btn-group">
                                                    <button type="button" class="btn btn-primary">Action</button>
                                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </button>
                                                    <div class="dropdown-menu" role="menu">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                        <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item" href="#">Separated link</a>
                                                    </div>
                                                </div>
                                            </td>
                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
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
