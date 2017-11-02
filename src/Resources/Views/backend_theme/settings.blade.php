@extends('btybug::layouts.mTabs',['index'=>'role_themes'])
@section('tab')
    {!! Form::model($theme,['class' => 'form-horizontal','url' => '/admin/settings/theme-settings/'.$theme->slug ]) !!}
    @include('layouts/themes/'.$theme->folder.'/'.$theme->settings['file'])
    {!! Form::close() !!}

    <div class="modal fade" id="magic-settings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        {!! Form::open(['url'=>'/admin/settings/theme-edit/live-save', 'id'=>'magic-form']) !!}
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    {!! Form::submit('Save',['class' => 'btn btn-success pull-right m-r-10']) !!}
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" style="min-height: 500px;">

                    {!! Form::hidden('slug',$theme->slug) !!}
                    {!! Form::hidden('role',$role) !!}
                    <div id="magic-body">

                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@stop