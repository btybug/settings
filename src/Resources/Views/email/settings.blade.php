@extends('layouts.tabs', ['index' => 'email_groups'])

@section('tab')
@section('parag')
 {!! Breadcrumbs::render('settings_emailtpls') !!}
@stop
<div class="container-fluid p-0 m-t-10">
  <div class="col-md-9 p-0">
    <div class="panel panel-default" >
      <div class="panel-heading bg-black-darker text-white">Email Settings</div>
      <div class="panel-body">
        {!! Form::open(['url'=>'/admin/settings/email/settings']) !!}
          
           <table class="table borderless m-0">
          <tr>
            <td width="23%"><div class="p-t-5">Email Driver</div></td>
            <td width="77%">{!! Form::select('driver',$drivers, @$data['driver'],['class'=>'form-control']) !!}</td>
          </tr>
          <tr>
            <td width="23%"><div  class="p-t-5">Host</div></td>
            <td width="77%"> {!! Form::text('host',@$data['host'],['class' => 'form-control']) !!} </td>
          </tr>
          
          <tr>
            <td width="23%"><div  class="p-t-5">Port</div></td>
            <td width="77%"> {!! Form::text('port',@$data['port'],['class' => 'form-control']) !!} </td>
          </tr>
          <tr>
            <td width="23%"><div  class="p-t-5">From Email</div></td>
            <td width="77%"> {!! Form::text('from[address]',@$data['from']['address'],['class' => 'form-control']) !!} </td>
          </tr>

          <tr>
            <td width="23%"><div  class="p-t-5">From Name</div></td>
            <td width="77%"> {!! Form::text('from[name]',@$data['from']['name'],['class' => 'form-control']) !!} </td>
          </tr>
          
          <tr>
            <td width="23%"><div  class="p-t-5">SMTP User Name</div></td>
            <td width="77%"> {!! Form::text('username',@$data['username'],['class' => 'form-control']) !!} </td>
          </tr>

          <tr>
            <td width="23%"><div  class="p-t-5">SMTP User Password</div></td>
            <td width="77%"> {!! Form::text('password',@$data['password'],['class' => 'form-control']) !!} </td>
          </tr>
 <tr>
            <td width="23%"></td>
            <td width="77%"> <input type="submit" class="btn btn-success  p-r-30 p-l-30" value="Save"> </td>
          </tr>
          
        </table>
       {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
@stop
