@extends('layouts.admin')
    @section('content')
      
     <ol class="breadcrumb">
  <li><a href="/">Dashboard</a></li>
  <li class="active">Front End Settings</li>
</ol>
     <div class="row">
        <div class="col-md-12">
            
             <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab">General</a></li>
    <li role="presentation"><a href="#notifications" aria-controls="notifications" role="tab" data-toggle="tab">Notifications & Tool Tips</a></li>
    <li role="presentation"><a href="#layout" aria-controls="layout" role="tab" data-toggle="tab">Layout</a></li>
    <li role="presentation"><a href="#header" aria-controls="header" role="tab" data-toggle="tab">Header</a></li>
  </ul>

  <!-- Tab panes -->
 {!! Form::model($fesetting,['url'=>'/admin/settings/setting/setting' , 'class' => 'form-horizontal','files'=>true]) !!}
  <div class="tab-content p-10 bg-silver overflow-y-hidden">
 
    <div role="tabpanel" class="tab-pane active" id="general">
       @include('settings::_partials.fegeneral')
    </div>
    <div role="tabpanel" class="tab-pane" id="notifications">
       @include('settings::_partials.fenotifications')
     </div>
    <div role="tabpanel" class="tab-pane" id="layout">
      @include('settings::_partials.felayout')
     </div>
     
     <div role="tabpanel" class="tab-pane" id="header">
      @include('settings::_partials.headerlayout')
     </div>
    
     
     <div class="clearfix"></div>
     <div class="col-sm-3">
     <button type="submit" class="btn btn-success btn-block" id="settings_savebtn">&nbsp;&nbsp;Save&nbsp;&nbsp;</button>
     </div>
  </div>
{!! Form::close() !!}
            
        </div>
     </div> 
      
@stop


