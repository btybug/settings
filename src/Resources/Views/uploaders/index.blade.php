@extends('layouts.admin')
    @section('content')
    
 {!! Breadcrumbs::render('settings_uploaders') !!}
<div> 
  
  <button id="delete_bulk" class="btn btn-default btn-sm btn-danger m-b-5" type="button" onclick="return confirm('Are you want to delete selected')"><i class="fa fa-plus"></i>&nbsp; Delete Selected</button>
  
  <a href="/admin/settings/uploaders/create">
  <button class="btn btn-default btn-sm btn-success pull-right m-b-5" type="button"><i class="fa fa-plus"></i>&nbsp; Add New</button>
  </a> 
  
 </div>
<div class="row">
  <div class="col-md-12 p-0">
    <table class="table table-bordered" id="tpl-table">
      <thead>
        <tr class="bg-black-darker text-white"> @foreach($form_fields as $fld)
          <th @if($fld=='Action') width="17%" @endif>{!! $fld !!}</th>
          @endforeach </tr>
      </thead>
      
      <tfoot>
          <tr>
              @foreach($form_fields as $fld)
              <td>
               @if($fld!='Action' && $fld!='#' && $fld!='Allowed Extensions' )
                 <input type="text" class="form-control width-full" placeholder="{!! $fld !!}" />
              @endif
               </td>
              @endforeach  
            </tr>
        </tfoot>
        
    </table>
  </div>
  
</div>

<!-- /.modal -->

@stop

@push('javascript')

  <script>
  $(function() {
		table = $('#tpl-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: '/admin/settings/uploaders/data',
			dom: 'Bfrtip',
			buttons: [
				'colvis','copy', 'csv', 'excel', 'pdf', 'print'
			],
			order: [[ 1, "asc" ]],
			columns:  {!! $columns!!}
		});
		
	});

  
  
     $(document).ready(function () {
		 $("#delete_bulk").click(function(){
   			deleteSelected('/admin/settings/uploaders/deleteblk','/admin/settings/uploaders');
		 });
		 
	 });
	
	
  </script>
@endpush
