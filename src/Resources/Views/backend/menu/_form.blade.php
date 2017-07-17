<div class="row hidden" >
  <div class="col-md-9"> 
    <!-- begin panel -->
    <div class="panel panel-default">
      <div class="panel-heading bg-black-darker text-white">Essentials</div>
      <div class="panel-body">
        <table width="100%">
          <tr>
            <td width="17%" height="50" valign="middle">Title</td>
            <td width="83%" height="50" valign="middle">{!! Form::text('title',null,['class'=>'form-control']) !!}</td>
          </tr>
          <tr>
            <td width="17%" height="50" valign="middle">&nbsp;</td>
            <td width="83%" height="50" valign="middle">{!! Form::submit($submitButtonText, array('class' => 'btn btn-success')) !!}</td>
          </tr>
        </table>
      </div>
    </div>
    <!-- end panel --> 
  </div>
</div>
<div class="row">
  <div class="col-md-12 text-right p-b-10"> {!! Form::submit($submitButtonText, array('class' => 'btn btn-success')) !!} </div>
</div>

<div class="row" >
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading bg-black-darker text-white">Menu: Main Navigation</div>
      <div class="panel-body form-inline">
        <div class="form-group col-md-4">
          <label for="menuname">Menu Name</label>
          {!! Form::text('title',null,['class'=>'form-control','placeholder'=>'Main Navigation','required']) !!} </div>
         <div class="form-group col-md-4">
         	<label for="menuname">Menu Place</label>
            <select name="menuType" id="menuType" class="form-control">
            		<option value="lnav">Left Navbar</option>
                    <option value="umenu">User menu</option>
             		<option value="lheader">Left header</option>
              		<option value="rheader">Right header</option>
            </select>
            
         </div>
         <div class="form-group col-md-4">
            <label for="menuname">User Role</label>
            {!! Form::select('user_role', $roles, null, ['class' => 'form-control']) !!} 
         </div>
         
      </div>
    </div>
  </div>
</div>



<div class="row">


  <div class="col-md-6" data-role="menuItems">
    <div class="panel panel-default">
      <div class="panel-heading bg-black-darker text-white">Menu Item  <button type="button" class="btn btn-success btn-xs pull-right" data-action="addnew"  data-target="#addnewform">Add New Item</button> <button type="button" class="btn btn-warning btn-xs m-r-10 pull-right" data-Duplicate="Duplicate">Duplicate Form Default</button></div>
      <div class="panel-body">
        @if(!@$menu)
        <div class="dd" id="nestable" data-menudata=''>
        @else
        <div class="dd"  id="nestable" data-menudata='{!!$raw_data!!}'>
       
        @endif
          
        </div>
        
        <p class="text-right">
          
        </p>
          {!! Form::textarea('raw_data', null, ['id' => 'nestable-output','class'=>'hidden']) !!} 
        </div>
        
    </div>
  </div>
  <div class="col-md-6" data-role="menuEdits">
    
    <div class="panel panel-default collapse" data-role="add-items" id="addnewform">
    		<div class="panel-heading bg-black-darker text-white"><span data-edit="text">Add New Item </span></div>
             <div class="panel-body">
             		<div class="row">
      <div class="col-md-12 form-horizontal">
        <div class="form-group">
          <label class="col-md-4 control-label" for="addtext">Text</label>
          <div class="col-md-7">
            <input id="addtext" name="addtext" type="text" placeholder="text" class="form-control input-md">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-4 control-label" for="adnewclass">Class</label>
          <div class="col-md-7">
            <input id="adnewclass" name="adnewclass" type="text" placeholder="Class" class="form-control input-md">
          </div>
        </div>
        <div class="form-group">
          <label for="selectlink2" class="col-md-4 control-label">Link</label>
          <div class="col-md-7">
            <select class="form-control" id="selectlink2">
              <option value="">Choose Link Type </option>
              <option value="left_nav_bar">Left navbar</option>
              <option value="leftheader">Left header</option>
              <option value="rightheader">Right header</option>
              <option value="usermenu">User menu</option>
              <option value="custom-link">Custom link</option>
            </select>
          </div>
        </div>
        <div class="form-group selectpage2 hide" data-selectpage="left_nav_bar">
          <label for="addcorepage" class="col-md-4 control-label">Left navbar</label>
          <div class="col-md-7">
             <select class="form-control" id="addleft_nav_bar" name="left_nav_bar">
               {!! $links['left_navbar'] !!}
             </select>
          </div>
        </div>
        <div class="form-group selectpage2 hide" data-selectpage="leftheader">
          <label for="addcustompage" class="col-md-4 control-label">Left header</label>
          <div class="col-md-7">
             <select class="form-control" id="addleftheader" name="addleftheader">
               {!! $links['header_left'] !!}
             </select>
          </div>
        </div>
        
        <div class="form-group selectpage2 hide" data-selectpage="rightheader">
          <label for="addcustom-link" class="col-md-4 control-label">Right Header</label>
          <div class="col-md-7">
           	<select name="addrightheader" id="addrightheader" class="form-control">
            		{!! $links['header_right'] !!}
            </select>
            
          </div>
        </div>
        
        <div class="form-group selectpage2 hide" data-selectpage="usermenu">
          <label for="addcustom-link" class="col-md-4 control-label">User menu</label>
          <div class="col-md-7">
          	<select name="addusermenu" id="addusermenu" class="form-control">
            		{!! $links['user_menu'] !!}
            </select>
          </div>
        </div>
        
        <div class="form-group selectpage2 hide" data-selectpage="custom-link">
          <label for="addcustom-link" class="col-md-4 control-label">Custom link</label>
          <div class="col-md-7">
            <input type="text" class="form-control" id="addcustom-link" placeholder="http://www.example.com/home">
          </div>
        </div>
        <div class="form-group">
          <label class="col-md-4 control-label" for="addnewtab"></label>
          <div class="col-md-7">
            <input type="checkbox" id="addnewtab">
            Open in new Tab? </div>
        </div>
        		<div class="form-group">
        		 <label class="col-md-4 control-label"></label>
        		<div class="col-md-7"><button type="button" class="btn btn-success save" data-action="save" data-role="addnew">Save</button></div>
        </div>
      </div>
    </div>
             </div>
    </div>
  </div>
</div>

@section('CSS')
   {!! HTML::style('/public/css/menu.css?v=0.7') !!}
 @stop
 
 @section('JS')

   {!! HTML::script('public/libs/bootbox/js/bootbox.min.js') !!}
   {!! HTML::script('public/libs/jquery.nestable/js/jquery.nestable.js') !!}
   {!! HTML::script('public/js/amenu.js?v=0.0') !!}

 @stop
