@extends('layouts.mTabs',['index'=>'settings'])

@section('parag')
{!! Breadcrumbs::render('settings_nitify') !!}
@stop

@section('tab')
<div role="tabpanel" class="m-t-10" id="notifications">

<div class="row">
        <div class="col-md-12 p-t-10">

            <table class="table table-bordered" id="tpl-table">
                <thead>
                <tr class="bg-black-darker text-white">
                    @foreach($form_fields as $fld)
                        <th @if($fld=='Action') width="10%" @endif>{!! $fld !!}</th>
                    @endforeach
                </tr>
                </thead>
            </table>
        </div>

    </div>
    
 </div>
@stop 

@include('tools::common_inc')

@push('javascript')
<script>
    $(function() {
        $('#tpl-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/admin/settings/system/notifications/cat-data',
            dom: 'Bfrtip',
			pageLength: '50',
            buttons: [
                'colvis','copy', 'csv', 'excel', 'pdf', 'print'
            ],
            columns: {!! $columns!!}
        });
    });
</script>
@endpush

