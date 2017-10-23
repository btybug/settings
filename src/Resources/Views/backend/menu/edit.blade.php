@extends('layouts.admin')
@section('content')
    <ol class="breadcrumb">
        <li><a href="/admin">Dashboard</a></li>
        <li><a href="/admin/settings/backgeneral">Back End Settings</a></li>
        <li><a href="/admin/settings/backmenu">Menues</a></li>
        <li class="active">Update {{$menu->title}}</li>
    </ol>

    {!! Form::model($menu,['method'=>'POST','url'=>'/admin/settings/backmenu/update', 'id'=>'edit_menu']) !!}
    {!! Form::hidden('id', $menu->id) !!}
    @include('settings::backend.menu._form',['submitButtonText'=>'Edit Menu'])

    {!! Form::close() !!}


@stop

