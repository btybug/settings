<div role="tabpanel" class="tab-pane" id="Twitter_Cards">
    <div class="panel panel-default m-t-10">
        <div class="panel-body p-b-0">
            <div class="panel panel-default m-t-10">
                <div class="form-group">
                    <label class="col-sm-2 control-label f-w-100 text-left">App ID</label>
                    <div class="col-sm-6"> {!! Form::text('twitter[client_id]',@$config['twitter']['client_id'],['class'=>'form-control']) !!} </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label f-w-100 text-left">App Secret</label>
                    <div class="col-sm-6"> {!! Form::text('twitter[client_secret]',@$config['twitter']['client_secret'],['class'=>'form-control']) !!} </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-2 control-label f-w-100 text-left">Redirect URI</label>
                    <div class="col-sm-6"> {!! Form::text(null,@$config['twitter']['redirect'],['class'=>'form-control']) !!} </div>
                    <div class="col-sm-2"><a class="btn btn-warning btn-sm btn-block"
                                             href="{!! url('api/social-network/auth/twitter') !!}" role="button">Authorizing</a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
