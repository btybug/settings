@extends('layouts.admin')
@section('content')

{!! Breadcrumbs::render('settings_filters') !!}
<div class="row p-0">
    <div class="col-md-3 p-0">
        <div class="panel panel-default">
            <div class="panel-heading  bg-black-darker text-white">Manage Filters</div>
            <div class="panel-body">
                <div class="form-group">
                    <label>Choose Module</label>
                    {!! Form::select('modules', $modules, null, ['class' => 'form-control','id'=>'modules']) !!}
                </div>
                <div class="form-group hide" id="filters_div">
                    <label class="control-label text-left">Choose Filter</label>
                    <select class="form-control" id="filters"></select>
                </div>
            </div>
        </div>
    </div>
    <div id="filters_container" class="col-md-9 p-r-0"></div>
</div>
@stop

@include('tools::common_inc')

@push('javascript')
<script>
    $('document').ready(function () {
        $('#modules').change(function () {
            var module = $(this).val();
            postAjax('/admin/settings/filter/filters', {module: module}, function (data) {
                $('#filters_div').removeClass('hide');
                $('#filters').html(data);
            });
        });

        $('#filters').change(function () {
            var filter = $(this).val();
            postAjax('/admin/settings/filter/filterdata', {
                module: $('#modules').val(),
                filter: filter
            }, function (data) {
                $('#filters_container').html(data);
            });
        });

    });

</script>
@endpush 