
<div class="panel panel-default">
    <div class="panel-heading bg-black-darker text-white">Facebook Login</div>
    <div class="panel-body">
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('facebook', 1,(config('config.facebook_login')) ? 'checked' : '',['id' => 'facebook']) !!} Enable Facebook Login
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('facebook_client_id','Client Id',['class' => 'col-sm-2 control-label'])!!}
            <div class="col-sm-10">
                {!! Form::input('text','facebook_client_id',(config('constants.MODE')) ? config('services.facebook.client_id') : '',['class'=>'form-control','placeholder'=>'Enter Facebook Client Id'])!!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('facebook_client_secret','Client Secret',['class' => 'col-sm-2 control-label'])!!}
            <div class="col-sm-10">
                {!! Form::input('text','facebook_client_secret',(config('constants.MODE')) ? config('services.facebook.client_secret') : '',['class'=>'form-control','placeholder'=>'Enter Facebook Client Secret'])!!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('facebook_redirect','Redirect Path',['class' => 'col-sm-2 control-label'])!!}
            <div class="col-sm-10">
                {!! Form::input('text','facebook_redirect',(config('constants.MODE')) ? config('services.facebook.redirect') : '',['class'=>'form-control','placeholder'=>'Enter Facebook Redirect Path'])!!}
            </div>
        </div>

        <div class="additional-box">
            {!! Form::submit("Save",['class' => 'btn btn-primary btn-sm pull-right']) !!}
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading bg-black-darker text-white">Google Plus Login</div>
    <div class="panel-body">
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('google', 1,(config('config.google_login')) ? 'checked' : '',['id' => 'google']) !!} Enable Google Plus Login
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('google_client_id','Client Id',['class' => 'col-sm-2 control-label'])!!}
            <div class="col-sm-10">
                {!! Form::input('text','google_client_id',(config('constants.MODE')) ? config('services.google.client_id') : '',['class'=>'form-control','placeholder'=>'Enter Google Client Id'])!!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('google_client_secret','Client Secret',['class' => 'col-sm-2 control-label'])!!}
            <div class="col-sm-10">
                {!! Form::input('text','google_client_secret',(config('constants.MODE')) ? config('services.google.client_secret') : '',['class'=>'form-control','placeholder'=>'Enter Google Client Secret'])!!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('google_redirect','Redirect Path',['class' => 'col-sm-2 control-label'])!!}
            <div class="col-sm-10">
                {!! Form::input('text','google_redirect',(config('constants.MODE')) ? config('services.google.redirect') : '',['class'=>'form-control','placeholder'=>'Enter Google Redirect Path'])!!}
            </div>
        </div>

        <div class="additional-box">
            {!! Form::submit("Save",['class' => 'btn btn-primary btn-sm pull-right']) !!}
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading bg-black-darker text-white">Twitter Login</div>
    <div class="panel-body">
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('twitter', 1,(config('config.twitter_login')) ? 'checked' : '',['id' => 'twitter']) !!} Enable Twitter Login
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('twitter_client_id','Client Id',['class' => 'col-sm-2 control-label'])!!}
            <div class="col-sm-10">
                {!! Form::input('text','twitter_client_id',(config('constants.MODE')) ? config('services.twitter.client_id') : '',['class'=>'form-control','placeholder'=>'Enter Twitter Client Id'])!!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('twitter_client_secret','Client Secret',['class' => 'col-sm-2 control-label'])!!}
            <div class="col-sm-10">
                {!! Form::input('text','twitter_client_secret',(config('constants.MODE')) ? config('services.twitter.client_secret') : '',['class'=>'form-control','placeholder'=>'Enter Twitter Client Secret'])!!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('twitter_redirect','Redirect Path',['class' => 'col-sm-2 control-label'])!!}
            <div class="col-sm-10">
                {!! Form::input('text','twitter_redirect',(config('constants.MODE')) ? config('services.twitter.redirect') : '',['class'=>'form-control','placeholder'=>'Enter Twitter Redirect Path'])!!}
            </div>
        </div>
        <div class="additional-box">
            {!! Form::submit("Save",['class' => 'btn btn-primary btn-sm pull-right']) !!}
        </div>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading bg-black-darker text-white">Github Login</div>
    <div class="panel-body">
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('github', 1,(config('config.github_login')) ? 'checked' : '',['id' => 'github']) !!} Enable Github Login
                    </label>
                </div>
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('github_client_id','Client Id',['class' => 'col-sm-2 control-label'])!!}
            <div class="col-sm-10">
                {!! Form::input('text','github_client_id',(config('constants.MODE')) ? config('services.github.client_id') : '',['class'=>'form-control','placeholder'=>'Enter Github Client Id'])!!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('github_client_secret','Client Secret',['class' => 'col-sm-2 control-label'])!!}
            <div class="col-sm-10">
                {!! Form::input('text','github_client_secret',(config('constants.MODE')) ? config('services.github.client_secret') : '',['class'=>'form-control','placeholder'=>'Enter Github Client Secret'])!!}
            </div>
        </div>
        <div class="form-group">
            {!! Form::label('github_redirect','Redirect Path',['class' => 'col-sm-2 control-label'])!!}
            <div class="col-sm-10">
                {!! Form::input('text','github_redirect',(config('constants.MODE')) ? config('services.github.redirect') : '',['class'=>'form-control','placeholder'=>'Enter Github Redirect Path'])!!}
            </div>
        </div>
        <div class="additional-box">
            {!! Form::submit("Save",['class' => 'btn btn-primary btn-sm pull-right']) !!}
        </div>
    </div>
</div>
