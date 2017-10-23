@extends('layouts.admin')
@section('content')
    {!! Breadcrumbs::render('settings_filters_update') !!}
    <div class="row">


        <div class="col-md-12 p-0">
            {!! Form::open(array('url' => ['/admin/settings/filter/update'], 'method' => 'POST','class' => 'form')) !!}
            {!! Form::hidden('id', $id) !!}
            @include('settings::filter._form')
            {!! Form::close() !!}
        </div>
    </div>
@stop 