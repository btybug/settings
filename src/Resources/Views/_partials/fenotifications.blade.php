<div class="m-10 p-15 bg-white">

<div class="form-group">
  <label for="inputEmail3" class="col-sm-3 control-label f-w-100">Notification position</label>
  <div class="col-sm-9"> {!! Form::select('notification_position',$position,null,['class'=>'form-control']) !!} </div>
</div>
<div class="form-group">
  <label for="inputPassword3" class="col-sm-3 control-label f-w-100">Notification class</label>
  <div class="col-sm-9"> {!! Form::select('notification_class',$classes,null,['class'=>'form-control']) !!} </div>
</div>
<div class="form-group">
  <label for="inputPassword3" class="col-sm-3 control-label f-w-100">Tooltip position</label>
  <div class="col-sm-9"> {!! Form::select('tooltip_position',$position,null,['class'=>'form-control']) !!} </div>
</div>
<div class="form-group">
  <label for="inputPassword3" class="col-sm-3 control-label f-w-100">Tooltip Class</label>
  <div class="col-sm-9"> {!! Form::select('tooltip_position',$classes,null,['class'=>'form-control']) !!} </div>
</div>
</div>
