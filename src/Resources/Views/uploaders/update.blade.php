@extends('layouts.admin')
@section('content')
    {!! Breadcrumbs::render('settings_uploaders_create') !!}
    <div class="row">


        <div class="col-md-12 p-0">
            {!! Form::model($uploader,['url'=>'/admin/settings/uploaders/update' , 'class' => 'form']) !!}
            {!! Form::hidden('id', $uploader->id) !!}
            @include('settings::uploaders._form')
            {!! Form::close() !!}
        </div>
    </div>
@stop 