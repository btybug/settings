@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li><a href="/admin">Dashboard</a></li>
        <li><a href="/admin/settings/backgeneral">Back End Settings</a></li>
        <li><a href="/admin/settings/backmenu">Menues</a></li>
        <li class="active">Create</li>
    </ol>

    {!! Form::open(['url'=>'/admin/settings/backmenu/create', 'id'=>'add_menu']) !!}
    @include('settings::backend.menu._form',['submitButtonText'=>'Add New Menu'])
    {!! Form::close() !!}
@stop 
