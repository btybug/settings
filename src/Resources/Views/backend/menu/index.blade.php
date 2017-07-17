@extends('layouts.admin')
    @section('content')
<ol class="breadcrumb">
  <li><a href="/admin">Dashboard</a></li>
  <li><a href="/admin/settings/backgeneral">Back End Settings</a></li>
  <li class="active">Menues</li>
</ol>
<div class="row">
  <div class="col-md-12"> 
    
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation"><a href="/admin/settings/backgeneral" role="tab">General</a></li>
      <li role="presentation"><a href="/admin/settings/backnotify" aria-controls="notifications" role="tab" >Notifications & Tool Tips</a></li>
      <li role="presentation"><a href="/admin/settings/backlayout" aria-controls="layout" role="tab" >Layout</a></li>
      <li role="presentation"><a href="/admin/settings/backheader" aria-controls="header" role="tab" >Header</a></li>
      <li role="presentation" class="active"><a href="/admin/settings/backmenu" aria-controls="adminMenu" role="tab" >Admin Menus</a></li>
    </ul>
    
    <!-- Tab panes -->
    
    <div role="tabpanel" class="tab-pane active p-t-10" id="menu">
      <div> <a href="/admin/settings/backmenu/create">
        <button type="button" class="btn btn-default btn-success pull-right m-b-5"><i class="fa fa-plus"></i>&nbsp; Add New Menu</button>
        </a> </div>
      <table width="100%" class="table table-bordered m-0 bg-white">
        <thead>
          <tr class="bg-black-darker text-white">
            <th width="42"><input type="checkbox" id="chk_unchk_all" value="" name="all"></th>
            <th width="76">#</th>
            <th width="300">Title</th>
            <th width="288">Menu place</th>
            <th width="155">Type</th>
            <th width="158">Role</th>
            <th width="236">Action</th>
          </tr>
        </thead>
        <tbody>
        
        @foreach($menues as $menu)
        <tr>
          <td scope="row">&nbsp;</td>
          <td scope="row">{{$menu->id}}</td>
          <td>{{$menu->title}}</td>
          <td>{{$menu->short_code}}</td>
          <td>
          @if(starts_with($menu->type,'default-'))
             Default
          @else
            Custom
          @endif 
          </td>
          <td>{{@$menu->userrole->name}}</td>
          <td>
            <a class="btn btn-default btn-primary btn-xs" href="{{url('admin/settings/backmenu/show', [$menu->id])}}">&nbsp;<i class="fa fa-eye"></i>&nbsp;</a>
            @if(!starts_with($menu->type,'default-'))
              <a class="btn btn-default btn-primary btn-xs" href="{{url('admin/settings/backmenu/update', [$menu->id])}}">&nbsp;<i class="fa fa-cog"></i>&nbsp;</a>
             
              <a onclick="return confirm('You want to delete it')" class="btn btn-danger btn-xs" href="{{url('admin/settings/backmenu/delete', [$menu->id])}}">&nbsp;<i class="fa fa-trash"></i>&nbsp;</a>  
              
            @endif
          
          </td>
        </tr>
        @endforeach
          </tbody>
        
      </table>
      <div class="clearfix"></div>
      <div class="col-sm-3 m-t-15 p-0">
        <button type="submit" class="btn btn-success btn-block" id="settings_savebtn">&nbsp;&nbsp;Save&nbsp;&nbsp;</button>
      </div>
    </div>
  </div>
</div>
@stop 
