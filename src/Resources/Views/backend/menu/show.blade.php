@extends('layouts.admin')
    @section('content')
<ol class="breadcrumb">
  <li><a href="/admin">Dashboard</a></li>
  <li><a href="/admin/settings/backgeneral">Back End Settings</a></li>
  <li><a href="/admin/settings/backmenu">Menues</a></li>
  <li class="active">{{$menu->title}}</li>
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
      <div class="panel panel-default">
            <div class="panel-heading bg-black-darker text-white">{{$menu->title}}</div>
            <div class="panel-body">
            	@if($menu->type=='default-lnav' OR $menu->type=='lnav')
                <div class="navbar-default sidebar p-t-0" style="position:inherit">
            			<div class="sidebar-nav navbar-collapse htmlmenu" id="side-menu"></div>
                </div>
                @endif
                
                @if($menu->type=='default-umenu' OR $menu->type=='umenu')
                    <div class="admin-right-sidebar right-nav htmlmenu"  style="position:inherit; border:solid 1px #ccc;">
                    
					</div>
                @endif

                @if($menu->type=='default-lheader' OR $menu->type=='lheader')
                    <div class="navbar navbar-default"  style="position:inherit; ">
                   		 <div class="navbar-top-links navbar-left hidden-xs htmlmenu">
                    
						</div>
                    
					</div>
                @endif
                

                @if($menu->type=='default-rheader' OR $menu->type=='rheader')
                    <div class="navbar navbar-default"  style="position:inherit; ">
                   		 <div class="navbar-top-links navbar-right htmlmenu">
                    
						</div>
                    
					</div>
                @endif
                
               
               
            </div>
          </div>
    </div>
  </div>
</div>

<div id="raw_data" data-mendata="{{$menu->raw_data}}" class="hide">{{$menu->raw_data}}</div>

 @section('JS')
<script>
var raw_data = $('#raw_data').data('mendata');

$(".htmlmenu").html(runmenu(raw_data));

	function runmenu (data, sub, t ){
		
	m = '';
	if(data){
			if(!sub){
				m  += '<ul class="nav">\n';
			}else{
				m  += '<ul class="dropdown-menu nav-second-level">\n';
			}
			 $.each(data, function(ci, cv){
				var micon = '';	
					if(cv['icon']){
						micon = '<i class="'+cv['icon']+'"></i>';
					}			
				if(cv['children']){
					m  +='<li class="dropdown">\n';
					m  +='<a href="'+cv['link']+'" class="dropdown-toggle" data-toggle="dropdown">'+micon+' <span class="htext"> '+cv['title']+' </span><span class="fa arrow fa-caret-down"></span>';	
				}else{
					m  +='<li>\n';
					m  +='<a href="'+cv['link']+'">'+micon+' <span class="htext">'+cv['title']+'</span>';
					if(cv['label']){
						m  +='<span class="label label-danger absolute">'+cv['label']+'</span>';
					}	
				}
				
				m  +='</a>\n';
				m  += runmenu (cv['children'], 'sub', t);	
				m  += '</li>\n';
			 })
			m  +='</ul>\n';
		}
	return m;
	
}
</script>

 @stop

@stop 
