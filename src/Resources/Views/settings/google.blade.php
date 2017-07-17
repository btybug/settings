<div role="tabpanel" class="tab-pane" id="Google_Analytics">
  <div class="panel panel-default m-t-10">
    <div class="panel-body p-b-0">
      <div class="m-10">
        <div class="form-group">
          <label class="col-sm-2 control-label f-w-100 text-left">Client Id</label>
          <div class="col-sm-6"> {!! Form::text('google[client_id]',@$config['google']['client_id'],['class'=>'form-control']) !!} </div>
        </div>
        
        <div class="form-group">
          <label class="col-sm-2 control-label f-w-100 text-left">Client Secret</label>
          <div class="col-sm-6"> {!! Form::text('google[client_secret]',@$config['google']['client_secret'],['class'=>'form-control']) !!} </div>
        </div>
        
		<div class="form-group">
          <label class="col-sm-2 control-label f-w-100 text-left">Redirect URI</label>
          <div class="col-sm-6"> {!! Form::text(null,@$config['google']['redirect'],['class'=>'form-control','readonly']) !!} </div>
          <div class="col-sm-2"> <a class="btn btn-warning btn-sm btn-block"  href="{!! url('api/social-network/auth/google') !!}" role="button">Authorizing</a> </div>
        </div>

        
      </div>
    </div>
  </div>
</div>
