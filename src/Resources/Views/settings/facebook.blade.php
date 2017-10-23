<div role="tabpanel" class="tab-pane active" id="Facebook">
    <div class="panel panel-default m-t-10">
        <div class="panel-body p-b-0">
            <div class="m-10">
                {{--<div class="form-group">--}}
                {{--<label class="col-sm-2 control-label f-w-100 text-left">App Title</label>--}}
                {{--<div class="col-sm-6"> {!! Form::text('facebook[app_title]',@$config['facebook']['app_title'],['class'=>'form-control']) !!} </div>--}}
                {{--</div>--}}
                <div class="form-group">
                    <label class="col-sm-2 control-label f-w-100 text-left">App ID</label>
                    <div class="col-sm-6"> {!! Form::text('facebook[client_id]',@$config['facebook']['client_id'],['class'=>'form-control']) !!} </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label f-w-100 text-left">App Secret</label>
                    <div class="col-sm-6"> {!! Form::text('facebook[client_secret]',@$config['facebook']['client_secret'],['class'=>'form-control']) !!} </div>
                </div>


                <div class="form-group">
                    <label class="col-sm-2 control-label f-w-100 text-left">Redirect URI</label>
                    <div class="col-sm-6"> {!! Form::text(null,@$config['facebook']['redirect'],['class'=>'form-control','readonly']) !!} </div>
                    <div class="col-sm-2"><a class="btn btn-warning btn-sm btn-block"
                                             href="{!! url('api/social-network/auth/facebook') !!}" role="button">Authorizing</a>
                    </div>
                </div>

                {{--<div class="form-group">--}}
                {{--<label class="col-sm-2 control-label f-w-100 text-left">Authorize Last Status</label>--}}
                {{--<div class="col-sm-6"> {!! Form::textarea('facebook[auth_last_status]', @$config['facebook']['auth_last_status'], ['class' => 'form-control','size' => '30x5']) !!} </div>--}}
                {{--<div class="col-sm-2"> <a class="btn btn-warning btn-sm btn-block" href="#" role="button">Validate</a> </div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
</div>
