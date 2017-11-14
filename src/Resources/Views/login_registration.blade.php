@extends('cms::layouts.mTabs',['index'=>'settings'])
@section('tab')

    <div class="tab-pane fade in active m-t-10" id="login">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 panels_wrapper panel_wrap">
                <!-- begin panel -->
                <div class="panel panel-default panels accordion_panels">
                    <div class="panel-heading bg-black-darker text-white" role="tab" id="headingLink">
                        <span class="panel_title">Login Configuration</span>
                        <a role="button" class="panelcollapsed collapsed" data-toggle="collapse"
                           data-parent="#accordion" href="#collapseLink1" aria-expanded="true"
                           aria-controls="collapseLink1">
                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                        </a>
                        <ul class="list-inline panel-actions">
                            <li><a href="#" panel-fullscreen="true" role="button" title="Toggle fullscreen"><i
                                            class="glyphicon glyphicon-resize-full"></i></a></li>
                        </ul>
                    </div>
                    <div id="collapseLink1" class="panel-collapse collapse in" role="tabpanel"
                         aria-labelledby="headingLink">
                        <div class="panel-body panel_body panel_1 show">
                            {!! Form::open(['route' => 'system.store','role' => 'form', 'class'=>'config-form ']) !!}
                            @include('settings::forms._login_form')
                            {!! Form::close() !!}
                        </div>
                    </div>

                {{--{!! Form::open(['route' => 'general.socialLoginStore','role' => 'form', 'class'=>'social-login-form form-horizontal']) !!}--}}
                {{--@include('settings::forms._social_logins_form')--}}
                {{--{!! Form::hidden('config_type','social_login')!!}--}}
                {{--{!! Form::close() !!}--}}

                <!-- end panel -->
                </div>
            </div>
        </div>
    </div>

@stop

@section('CSS')
    {!! HTML::style('public/css/admin_pages.css') !!}
    {!! HTML::style('public/css/menu.css?v=0.16') !!}
    {!! HTML::style('public/css/tool-css.css?v=0.23') !!}
    {!! HTML::style('public/css/page.css?v=0.15') !!}
@stop
@section('JS')
    {!! HTML::script('public/js/admin_pages.js') !!}
    {!! HTML::script("/resources/assets/js/UiElements/bb_styles.js?v.5") !!}
    {!! HTML::script('public/js/nestedSortable/jquery.mjs.nestedSortable.js') !!}
    {!! HTML::script('public/js/bootbox/js/bootbox.min.js') !!}
    {!! HTML::script('public/js/icon-plugin.js?v=0.4') !!}
@stop
