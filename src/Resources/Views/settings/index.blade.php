@extends('layouts.mTabs',['index'=>'settings'])
@section('tab')
{!! Form::model(null,['method'=>'POST','url'=>'/admin/settings/api-settings/update', 'id'=>'edit_sidebar']) !!}
<div class="row">
  <div class="col-md-12 p-t-10">
    
     <ul class="nav nav-pills">
      <li role="presentation" class="active"><a href="#Facebook" aria-controls="Facebook" role="tab" data-toggle="tab">Facebook</a></li>
      <li role="presentation"><a href="#Twitter_Cards" aria-controls="Twitter" role="tab" data-toggle="tab">Twitter</a></li>
      <li role="presentation"><a href="#Google_Analytics" aria-controls="Google_Analytics" role="tab" data-toggle="tab">Google</a></li>
      <li role="presentation"><a href="#Linkedin" aria-controls="Linkedin" role="tab" data-toggle="tab">Linkedin</a></li>
      <li role="presentation"><a href="#Github" aria-controls="Github" role="tab" data-toggle="tab">GitHub</a></li>

      <li class="pull-right">{!! Form::submit('Save Changes', array('class' => 'btn btn-primary')) !!}</li>
    </ul>
    
    <div class="tab-content  overflow-y-hidden form-horizontal">
          @include('settings::settings.facebook')
          @include('settings::settings.twittercards')
          @include('settings::settings.google')
          @include('settings::settings.linkedin')
          @include('settings::settings.github')

    </div>
  </div>
</div>
{!! Form::close() !!}

@stop 

@push('javascript')
<script>
  (function(w,d,s,g,js,fs){
    g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
    js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
    js.src='https://apis.google.com/js/platform.js';
    fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
  }(window,document,'script'));
</script>
<script>
$(document).ready(function() {
  /* Automagically jump on good tab based on anchor; for page reloads or links */
  if(location.hash) {
    $('a[href=' + location.hash + ']').tab('show');
  }

  /* Update hash based on tab, basically restores browser default behavior to
     fix bootstrap tabs */
  $(document.body).on("click", "a[data-toggle]", function(event) {
    location.hash = $(this).attr("href");
  });
});
</script>
<script type="text/javascript">
// Enter an API key from the Google API Console:
//   https://console.developers.google.com/apis/credentials?project=_
var apiKey = "{!!@$googleanalytics['client_secret'] !!}";
// Enter a client ID for a web application from the Google API Console:
//   https://console.developers.google.com/apis/credentials?project=_
// In your API Console project, add a JavaScript origin that corresponds
//   to the domain where you will be running the script.
var clientId = "{!! @$googleanalytics['client_id']!!}";
// Enter one or more authorization scopes. Refer to the documentation for
// the API or https://developers.google.com/identity/protocols/googlescopes
// for details.
var scopes = 'profile';
var auth2; // The Sign-In object.
var authorizeButton = document.getElementById('authorize-button');
var signoutButton = document.getElementById('signout-button');
function handleClientLoad() {
  // Load the API client and auth library
  gapi.load('client:auth2', initAuth);
}
function initAuth() {
  gapi.client.setApiKey(apiKey);
  gapi.auth2.init({
    client_id: clientId,
    scope: scopes
  }).then(function () {
    auth2 = gapi.auth2.getAuthInstance();
    // Listen for sign-in state changes.
    auth2.isSignedIn.listen(updateSigninStatus);
    // Handle the initial sign-in state.
    updateSigninStatus(auth2.isSignedIn.get());
    authorizeButton.onclick = handleAuthClick;
    signoutButton.onclick = handleSignoutClick;
  });
}
function updateSigninStatus(isSignedIn) {
  if (isSignedIn) {
    authorizeButton.style.display = 'none';
    signoutButton.style.display = 'block';
    makeApiCall();
  } else {
    authorizeButton.style.display = 'block';
    signoutButton.style.display = 'none';
  }
}
function handleAuthClick(event) {
  auth2.signIn();
}
function handleSignoutClick(event) {
  auth2.signOut();
}
// Load the API and make an API call.  Display the results on the screen.

</script>
<script src="https://apis.google.com/js/api.js?onload=handleClientLoad"></script>
@endpush
