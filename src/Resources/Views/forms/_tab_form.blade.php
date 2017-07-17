<div class="form-group">
    {!! Form::label('Social name','',[])!!}
    {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Enter Login Timeout'])!!}
    <div class="help-block">(your social network name for example fasebook)</div>
</div>
<div class="form-group">
    {!! Form::label('Key','',[])!!}
    {!! Form::text('key',null,['class'=>'form-control','placeholder'=>'Enter Login Timeout'])!!}
    <div class="help-block">(access token to api)</div>
</div>
<div class="additional-box">
    {!! Form::submit("Save",['class' => 'btn btn-primary btn-sm pull-right']) !!}
</div>