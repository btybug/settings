@extends('layouts.admin')
@section('content')
    {!! Breadcrumbs::render('settings_uploaders_create') !!}
    <div class="row">


        <div class="col-md-12 p-0">
            {!! Form::open(array('url' => ['/admin/settings/uploaders/create'], 'method' => 'POST','class' => 'form')) !!}
            @include('settings::uploaders._form')
            {!! Form::close() !!}
        </div>
    </div>
@stop 