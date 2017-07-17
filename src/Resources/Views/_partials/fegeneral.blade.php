
<div class="m-10 p-15 bg-white overflow-y-hidden">

<div class="form-group">
  <label for="inputEmail3" class="col-sm-3 control-label f-w-100">Site Name</label>
  <div class="col-sm-9"> {!! Form::text('site_name' ,null, ['class'=>'form-control']) !!} </div>
</div>
<div class="form-group">
  <label for="inputPassword3" class="col-sm-3 control-label f-w-100">Site logo</label>
  <div class="col-sm-9"> {!! Form::file('site_logo') !!} </div>
</div>
<div class="form-group">
  <label for="inputPassword3" class="col-sm-3 control-label f-w-100">Site description</label>
  <div class="col-sm-9"> {!! Form::textarea('site_description',null,['class'=>'form-control']) !!} </div>
</div>

<div class="form-group">
  <label for="inputPassword3" class="col-sm-3 control-label f-w-100">Theme orientation</label>
  <div class="col-sm-9"> {!! Form::select('theme_orientation',$orientations,null,['class'=>'form-control']) !!} </div>
</div>
</div>
