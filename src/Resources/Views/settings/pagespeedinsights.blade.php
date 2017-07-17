<div role="tabpanel" class="tab-pane" id="PageSpeed_Insights">
    <div class="m-10">

        <div class="form-group">
            <label class="col-sm-2 control-label f-w-100 text-left">Google Developer Key</label>
            <div class="col-sm-7"> {!! Form::text('pagespeedinsights[developer_key]',@$pagespeedinsights['developer_key'],['class'=>'form-control']) !!} </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label f-w-100 text-left">Supported Languages</label>
            <div class="col-sm-7"> {!! Form::select('pagespeedinsights[supported_languages]', [''=>'Profile ID'], @$pagespeedinsights['supported_languages'], ['class' => 'form-control']) !!}  </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label f-w-100 text-left">Report Type</label>
            <div class="col-sm-7"> {!! Form::select('pagespeedinsights[report_type]', [''=>'Profile ID'], @$pagespeedinsights['report_type'], ['class' => 'form-control']) !!}  </div>
        </div>


        <div class="form-group">
            <label class="col-sm-2 control-label f-w-100 text-left">Request Last Status</label>
            <div class="col-sm-7"> {!! Form::textarea('pagespeedinsights[request_last_status]', @$pagespeedinsights['request_last_status'], ['class' => 'form-control','size' => '30x5']) !!}  </div>
        </div>
    </div>
</div>