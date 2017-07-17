{!! HTML::style("/resources/assets/css/bootstrap.css") !!}
{!! HTML::style("/resources/assets/js/font-awesome/css/font-awesome.min.css") !!}
{!! HTML::style("/resources/assets/js/jqueryui/css/jquery-ui.min.css") !!}
{!! HTML::style('/resources/assets/css/preview-template.css') !!}
{!! HTML::style("resources/assets/css/core_styles.css") !!}


{!! csrf_field() !!}
<div class="body_ui previewlivesettingifream" data-settinglive="content" id="widget_container">
    {!! $htmlBody !!}
</div>
<div class="layoutCoresetting hide animated bounceInRight" data-settinglive="settings">
 <div class="container-fluid"> 
  {!! Form::model($settings,['url'=>'/admin/templates/settings/'.$id, 'id'=>'add_custome_page','files'=>true]) !!}
  {!! $htmlSettings !!}
  {!! Form::close() !!}

  </div>
</div>

@include('resources::assests.magicModal')
{!! HTML::script("resources/assets/js/jquery-2.1.4.min.js") !!}
{!! HTML::script("resources/assets/js/jqueryui/js/jquery-ui.min.js") !!}
{!! HTML::script("resources/assets/js/bootstrap.min.js") !!}
{!! HTML::script("resources/assets/js/UiElements/bb_styles.js?v.5") !!}
{!! HTML::script("resources/assets/js/UiElements/ui-preview-setting.js") !!}
{!! HTML::script("resources/assets/js/UiElements/ui-settings.js") !!}
@yield('JS')

@stack('javascript')