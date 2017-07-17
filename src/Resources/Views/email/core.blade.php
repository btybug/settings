@extends('layouts.tabs', ['index' => 'email_groups'])

@section('tab')
@section('parag')
 {!! Breadcrumbs::render('settings_emailtpls') !!}
@stop
 
<div class="container-fluid p-0 m-t-10">
  <div class="col-md-3 p-l-0">
  <div class="panel panel-default" >
    <div class="panel-heading bg-black-darker text-white">Email Groups</div>
    <div class="panel-body">
    	
    	<ul class="list-group source listwithlink" data-role="grouplist">
         @foreach($groups_list as $list)
           <li class="list-group-item"><a href="/admin/settings/email/core/{!! $list->id !!}">  {!! $list->name !!} </a></li>
         @endforeach
         </ul>
     </div>
  </div>
  </div>
 @if($count > 0 )
<div class="col-md-9 p-0"> 
  <div class="m-0">
    <table class="table table-bordered" id="tpl-table">
        <thead>
          <tr class="bg-black-darker text-white">
            <th> Title </th>
            <th> Subject </th>
             <th> Receiver </th>
            <th> Updated </th>
            <th width="15%"> Action </th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <td> <input type="text" class="form-control width-full" placeholder="Title" /> </td>
            <td> <input type="text" class="form-control width-full" placeholder="Subject" /> </td>
            <td> <input type="text" class="form-control width-full" placeholder="Receiver" /> </td>
            <td> <input type="text" class="form-control width-full" placeholder="Updated" /> </td>
            <td></td>
          </tr>
        </tfoot>
      </table>
  </div>
  <div>
@endif
    
  </div>
 </div>
</div> 

 
@include('tools::common_inc')
@stop
@section('CSS')
   {!! HTML::style('/public/css/themes-settings.css?v=0.4') !!}
 @stop

@section('JS')

<script>
    
	
	  
	$(function() {
		$('#submit_btn').hide();
		 
		table = $('#tpl-table').DataTable({
			processing: true,
			serverSide: true,
			pageLength: 1000,
			ajax: '/admin/settings/email/data/{{$id}}',
			dom: 'Bfrtip',
			buttons: [
				'colvis','copy', 'csv', 'excel', 'pdf', 'print'
			],
			columns: [
			  {data: 'name', name: 'title'},
			  {data: 'subject', name: 'subject'},
			  {data: 'to_', name: 'to_'},
			  {data: 'updated_at', name: 'updated_at'},
			  {data: 'action', name:'action', orderable:false } 
			]
		});
		
		table.columns().every(function() {
		  var string = this;
		  $("input", this.footer()).on("keyup change", function() {
			if (string.search() !== this.value) {
			  string.search(this.value).draw();
			}
		  });
		});
		
		
	});

   </script>

 
@stop 
