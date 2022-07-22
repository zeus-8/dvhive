@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Editar Registros</h1>
@stop

@section('content')
<br><br><br>
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Consulta de Alumno</h3>
            </div>
            <div class="card-body">
                {!! Form::model($user,['route'=>['maintenance/updateStudent', $user->pin], 'method'=>'PUT']) !!}
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">DOCUMENTO</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" disabled  placeholder="Documento" value="{{ substr($user->pin, 2) }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-feedback">
                                {!! Form::label('Nombre') !!}
                                {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Nombre']) !!}
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-feedback">
                                {!! Form::label('Apellido') !!}
                                {!! Form::text('surname', null, ['class'=>'form-control', 'placeholder'=>'Apellido']) !!}
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group has-feedback">
                                {!! Form::label('Email') !!}
                                {!! Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'Email']) !!}
                                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                        </div>
                        {{--
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">CARRERA</label>
                                <select class="form-control select2bs4" style="width: 100%;">
                                    <option value="0">-- Seleccione --</option>
                                    @foreach ($careers as $career)
                                        <option @if ($user->id_career == $career->id ) selected="selected" @endif  value="{{ $career->id }}">{{ $career->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        --}}
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">AÑO</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Año" value="{{ $user->period_year }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">PERIODO DE INICIO</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Año" value="{{ $user->period_year }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">TURNO</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exampleInputEmail1">MODALIDAD</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-4 offset-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" class="btn btn-block btn-outline-success btn-lg">Modificar</button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('maintenance') }}" class="btn btn-block btn-outline-danger btn-lg">Cancelar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
  
@stop