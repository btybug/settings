@extends('layouts.admin')

@section('content')

    {!! Breadcrumbs::render('template_sample') !!}


    <div class="row">
        <div class="col-md-12">
            <!-- begin panel -->
            <div class="panel panel-default">
                <div class="panel-heading bg-black-darker text-white">Template Information</div>
                <div class="panel-body">
                    {!! Form::open(['url'=>'/admin/templates/start']) !!}
                    @include('forms.7')
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- end panel -->
        </div>
    </div>
@stop 
