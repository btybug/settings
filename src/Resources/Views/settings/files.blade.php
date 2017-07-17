@extends('layouts.admin')

@section('content')
<div> {!! Breadcrumbs::render('seo-settings-files') !!} </div>
{!! Form::model(null,['method'=>'POST','url'=>'/admin/seo/settings/update-files', 'id'=>'edit_sidebar']) !!}
<div>
<ul class="list-group">
  <li class="list-group-item">
    <div> Here you can edit the robots.txt and .htaccess files.</div>
    <div class="p-t-10">
     <a href="http://www.robotstxt.org/robotstxt.html" target="_blank"> robots.txt file help</a> (incorrectly editing your robots.txt file could block search engines from targeting your site)
    </div>

    <div class="p-t-10">
     <a href="http://httpd.apache.org/docs/2.4/howto/htaccess.html" target="_blank"> .htaccess file help</a> (.htaccess file is static and it is possible that WordPress or another plugin may overwrite this file, also if you've inserted code that your web server can't understand, you can disable your entire website in this way,
      <span class="text-warning"> <strong>so make a backup of this file, found on the root of your website, before making changes with this module)</strong></span>
    </div>
    
  </li>
</ul>
  <div class="col-md-12 p-b-10">{!! Form::submit('Save Changes', array('class' => 'btn btn-primary pull-right')) !!}</div>
  <div class="col-md-6 p-0">
    <div class="panel panel-default">
      <div class="panel-heading  bg-black-darker text-white">robots.txt file</div>
      <div class="panel-body p-0">
        <table class="table no-border m-0">
          <tr>
            <td>{!! Form::textarea('robots', $robots, ['size' => '30x20','class'=>'form-control']) !!}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  
  <div class="col-md-6 p-r-5">
    <div class="panel panel-default">
      <div class="panel-heading  bg-black-darker text-white">.htaccess file</div>
      <div class="panel-body p-0">
        <table class="table no-border m-0">
          <tr>
            <td>{!! Form::textarea('htaccess', $htaccess, ['size' => '30x20','class'=>'form-control']) !!}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  
</div>
{!! Form::close() !!}
@stop 