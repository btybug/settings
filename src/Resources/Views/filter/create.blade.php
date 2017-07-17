@extends('layouts.admin')
@section('content')
{!! Breadcrumbs::render('settings_filters_create') !!}
<div class="row">

  <div class="col-md-12 p-0"> 
     {!! Form::open(array('url' => ['/admin/settings/filter/create'], 'method' => 'POST','class' => 'form')) !!}
        @include('settings::filter._form')
     {!! Form::close() !!}     
  </div>
   </div>
@stop 