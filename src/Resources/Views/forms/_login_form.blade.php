<div class="form-group">
    {!! Form::label('login_timeout','Login Timeout',[])!!}
    {!! Form::input('text','login_timeout',(isset($system['login_timeout']))?$system['login_timeout']: Config::get('session.lifetime'),['class'=>'form-control','placeholder'=>'Enter Login Timeout'])!!}
    <div class="help-block">(In minutes)</div>
</div>

<div class="form-group">
    {!! Form::label('login_timeout','New registered user group ')!!}
    {!! Form::select('groups',$groups,null,['class'=>'form-control'])!!}
    <div class="help-block">(In minutes)</div>
</div>

<div class="form-group">
    {!! Form::label('enable_registration','Enable Registration',['class' => 'control-label labels'])!!}
    <div class="">
        <div class="radio">
            <label class="radio_label">
                {!! Form::radio('enable_registration', 1, (isset($system['enable_registration']) && $system['enable_registration']) ? 'checked' : '') !!}
                Yes
            </label>
            <label class="radio_label">
                {!! Form::radio('enable_registration', 0, (!isset($system['enable_registration']) || ($system['enable_registration'] == 0) ) ? 'checked' : '') !!}
                No
            </label>
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('email_activation','Email Activation Required',['class' => 'control-label labels'])!!}
    <div class="">
        <div class="radio">
            <label class="radio_label">
                {!! Form::radio('email_activation', 1,(isset($system['email_activation']) && $system['email_activation']) ? 'checked' : '') !!}
                Yes
            </label>
            <label class="radio_label">
                {!! Form::radio('email_activation', 0, (!isset($system['email_activation']) || ($system['email_activation'] == 0) ) ? 'checked' : '') !!}
                No
            </label>
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('browser_close','Session end on Browser close',['class' => 'control-label labels'])!!}
    <div class="">
        <div class="radio">
            <label class="radio_label">
                {!! Form::radio('browser_close', 1, (isset($system['browser_close']) && $system['browser_close']) ? 'checked' : '') !!}
                Yes
            </label>
            <label class="radio_label">
                {!! Form::radio('browser_close', 0, (!isset($system['browser_close']) || ($system['browser_close'] == 0) ) ? 'checked' : '') !!}
                No
            </label>
        </div>
    </div>
</div>

<div class="form-group">
    {!! Form::label('email_on_register','Welcome email on Register',['class' => 'control-label labels'])!!}
    <div class="">
        <div class="radio">
            <label class="radio_label">
                {!! Form::radio('email_on_register', 1, (isset($system['email_on_register']) && $system['email_on_register']) ? 'checked' : '') !!}
                Yes
            </label>
            <label class="radio_label">
                {!! Form::radio('email_on_register', 0, (!isset($system['email_on_register']) || ($system['email_on_register'] == 0) ) ? 'checked' : '') !!}
                No
            </label>
        </div>
    </div>
</div>
{{--<div class="form-group">--}}
{{--{!! Form::label('tnc_on_register','Terms & Condition on Registration',['class' => 'col-sm-6 control-label'])!!}--}}
{{--<div class="col-sm-6">--}}
{{--<div class="radio">--}}
{{--<label>--}}
{{--{!! Form::radio('tnc_on_register', 1, (config('config.tnc_on_register')) ? 'checked' : '') !!} Yes--}}
{{--</label>--}}
{{--<label>--}}
{{--{!! Form::radio('tnc_on_register', 0, (!config('config.tnc_on_register')) ? 'checked' : '') !!} No--}}
{{--</label>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{!! Form::submit(isset($buttonText) ? $buttonText : "Save",['class' => 'btn btn-primary']) !!}
<div class="clear"></div>
