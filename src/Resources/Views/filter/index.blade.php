@extends('layouts.admin')
@section('content')

    {!! Breadcrumbs::render('settings_filters') !!}

    <div>

        <button id="delete_bulk" class="btn btn-default btn-sm btn-danger m-b-5" type="button"
                onclick="return confirm('Are you want to delete selected')"><i class="fa fa-plus"></i>&nbsp; Delete
            Selected
        </button>

        <a href="/admin/settings/filter/create">
            <button class="btn btn-default btn-sm btn-success pull-right m-b-5" type="button"><i class="fa fa-plus"></i>&nbsp;
                Add New
            </button>
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


            </table>
        </div>

    </div>

@stop

@include('tools::common_inc')

@push('javascript')
    <script>
        $(function () {
            table = $('#tpl-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '/admin/settings/filter/data',
                dom: 'Bfrtip',
                buttons: [
                    'colvis', 'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                order: [[1, "asc"]],
                columns: {!! $columns !!}
            });

            table.columns().every(function () {
                var string = this;
                $("input", this.footer()).on("keyup change", function () {
                    if (string.search() !== this.value) {
                        string.search(this.value).draw();
                    }
                });
            });

        });


        $(document).ready(function () {
            $("#delete_bulk").click(function () {
                deleteSelected('/admin/settings/filter/deleteblk', '/admin/settings/filter');
            });

        });


    </script>
@endpush 