@extends('layouts.uiPreview')

@section('content')
    <div class="center-block" id="widget_container">
        {!! $html !!}
    </div>
    <textarea type="hidden" class="hide" id="hidden_data">{!! $json !!}</textarea>
@stop

@section('settings')
    <div class="withoutifreamsetting animated bounceInRight hide" data-settinglive="settings">
        {!! Form::model($model,['id'=>'add_custome_page']) !!}
            @include($settingsHtml)
        {!! Form::close() !!}
    </div>
    <div class="modal fade" id="magic-settings" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        {{--{!! Form::open(['url'=>'/admin/backend/theme-edit/live-save', 'id'=>'magic-form']) !!}--}}
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{--{!! Form::submit('Save',['class' => 'btn btn-success pull-right m-r-10']) !!}--}}
                    <h4 class="modal-title" id="myModalLabel"></h4>
                </div>
                <div class="modal-body" style="min-height: 500px;">

                    <div id="magic-body">

                    </div>
                </div>
            </div>
        </div>
        {{--{!! Form::close() !!}--}}
    </div>
    @include('resources::assests.magicModal')

@stop
@section('CSS')
   {!! HTML::style("/admin/framework-versions/version/get-css-live") !!}
    {!! HTML::style("resources/assets/css/core_styles.css") !!}
    {!! HTML::style("resources/assets/css/builder-tool.css") !!}
    {!! HTML::style("https://jqueryvalidation.org/files/demo/site-demos.css") !!}

    {!! HTML::style('/resources/assets/css/preview-template.css') !!}
    {!! HTML::style('/resources/assets/js/animate/css/animate.css') !!}
    {!! HTML::style('/resources/assets/js/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') !!}
    @if(isset($model->css) && $model->css)
        @foreach($model->css as $css)
            {!! HTML::style('resources/views/ContentLayouts/'.$model->folder.'/css/'.$css) !!}
        @endforeach
    @endif
    @yield('CSS')
    @stack('css')
@stop
@section('JS')
   
    {!! HTML::script("resources/assets/js/UiElements/bb_styles.js?v.5") !!}
    {!! HTML::script("resources/assets/js/UiElements/bb_div.js") !!}
    {!! HTML::script("resources/assets/js/UiElements/ui-preview-setting.js") !!}
    {!! HTML::script("resources/assets/js/UiElements/ui-settings.js") !!}
    {!! HTML::script("resources/assets/js/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js") !!}
    {!! HTML::script("https://cdn.jsdelivr.net/jquery.validation/1.15.0/jquery.validate.min.js") !!}
    {!! HTML::script("https://cdn.jsdelivr.net/jquery.validation/1.15.0/additional-methods.min.js") !!}
    {!! HTML::script("resources/assets/js/tinymice/tinymce.min.js") !!}
    @if(isset($model->js) && $model->js)
        @foreach($model->js as $js)
            {!! HTML::script('/resources/views/ContentLayouts/'.$model->folder.'/js/'.$js) !!}
        @endforeach
    @endif
    {!! HTML::script('/resources/assets/js/UiElements/content-layout-settings.js') !!}
    @yield('JS')
    @stack('javascript')
@stop
