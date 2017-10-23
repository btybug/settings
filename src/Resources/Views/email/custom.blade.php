@extends('layouts.tabs', ['index' => 'email_groups'])

@section('tab')

@section('parag')
    {!! Breadcrumbs::render('settings_emailtpls') !!}
@stop

<div class="container-fluid p-0 m-t-10">
    <div class="col-md-3 p-l-0">
        <div class="panel panel-default">
            <div class="panel-heading bg-black-darker text-white">Email Groups<a data-toggle="collapse"
                                                                                 href="#addnewGroup"
                                                                                 class="btn btn-default btn-xs pull-right"><i
                            class="fa fa-plus" aria-hidden="true"></i></a></div>
            <div class="panel-body">
                <div id="addnewGroup" class="collapse posrelative">
                    <div class="loadinanimation hide"></div>
                    <div class="row">
                        <div class="form-group col-xs-8 col-sm-8 p-0 p-r-5">
                            <input type="text" class="form-control" placeholder="Add New Group"
                                   data-selector="newgroup">
                        </div>
                        <div class="form-group col-xs-4 col-sm-4 p-0">
                            <button class="btn btn-primary btn-block p-l-0 p-r-0" type="button"
                                    data-action="saveNewGroup">save
                            </button>
                        </div>
                    </div>
                </div>
                <ul class="list-group source listwithlink" data-role="grouplist">
                    @foreach($groups_list as $list)
                        <li class="list-group-item"><a
                                    href="/admin/settings/email/custom/{!! $list->id !!}">  {!! $list->name !!} </a><span
                                    class="listtool"><a href="#" class="btn btn-default" data-action="editGroup"
                                                        data-id="{!! $list->id !!}" data-title="{!! $list->name !!}"><i
                                            class="fa fa-pencil" aria-hidden="true"></i></a> <a href="#"
                                                                                                class="btn btn-default"
                                                                                                data-action="deleteGroup"
                                                                                                data-id="{!! $list->id !!}"><i
                                            class="fa fa-trash-o" aria-hidden="true"></i></a></span></li>
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
                        <th> Title</th>
                        <th> Subject</th>
                        <th> Receiver</th>
                        <th> Updated</th>
                        <th width="15%"> Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <td><input type="text" class="form-control width-full" placeholder="Title"/></td>
                        <td><input type="text" class="form-control width-full" placeholder="Subject"/></td>
                        <td><input type="text" class="form-control width-full" placeholder="Receiver"/></td>
                        <td><input type="text" class="form-control width-full" placeholder="Updated"/></td>
                        <td></td>
                    </tr>
                    </tfoot>
                </table>
            </div>
            <div>

            </div>
        </div>
    @endif

</div>
<!-- /.modal -->
<div class="modal fade" id="addEmail" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Add New Email</h4>
            </div>
            {!! Form::open(['route' => 'system.email.new', 'method' => 'post', 'class' => 'form-horizontal']) !!}
            {!! Form::hidden('group_id',$id) !!}
            {!! Form::hidden('email_id','',['class' => 'emailID']) !!}
            <div class="modal-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10"> {!! Form::text('name','',['class' => 'form-control emailName','placeholder' => 'Name']) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Email</button>
                </div>
                {!! Form::close() !!} </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
<!-- /.modal -->

@include('tools::common_inc')
@stop
@section('CSS')
    {!! HTML::style('/public/css/themes-settings.css?v=0.4') !!}
@stop

@section('JS')

    <script>

        $('body').on('click', '.add-new-email', function () {
            $('#addEmail form')[0].reset();
            $('#addEmail form').attr('action', '/admin/settings/add-email');
            $('#addEmail').modal();
        });

        $(function () {
            $('#submit_btn').hide();

            table = $('#tpl-table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 1000,
                ajax: '/admin/settings/email/data/{{$id}}',
                dom: 'Bfrtip',
                buttons: [
                    'colvis', 'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                columns: [
                    {data: 'name', name: 'title'},
                    {data: 'subject', name: 'subject'},
                    {data: 'to_', name: 'to_'},
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'action', name: 'action', orderable: false}
                ]
            });

            table.columns().every(function () {
                var string = this;
                $("input", this.footer()).on("keyup change", function () {
                    if (string.search() !== this.value) {
                        string.search(this.value).draw();
                    }
                });
            });
            $("div.dt-buttons").html('<button class="btn btn-info add-new-email"><i class="fa fa-plus"></i>&nbsp; Add New Email</button>');

        });

    </script>

    <script>
        $(document).ready(function () {
            $('[data-action="saveNewGroup"]').click(function (e) {
                e.preventDefault()
                var getvalue = $('[data-selector="newgroup"]').val()
                var getEdit = $(this).attr('data-edit');
                if (getvalue == '') {
                    $('[data-selector="newgroup"]').focus()
                    return false;
                }
                $('.loadinanimation').removeClass('hide');
                if (getEdit) {
                    var id = $(this).data('edit')
                    $('[data-role="grouplist"] li.editActive > a').text(getvalue)
                    $('[data-role="grouplist"] li.editActive [data-action="editGroup"]').data('title', getvalue)
                    var afterDone = function () {
                        $('[data-role="grouplist"] li').removeClass('editActive');
                        $("#addnewGroup").collapse("hide");
                        $('.loadinanimation').addClass('hide');
                    }
                    postAjax('/admin/settings/email/editgroup', {'group': getvalue, 'id': id}, afterDone);
                    $('[data-action="saveNewGroup"]').removeAttr('data-edit');
                } else {
                    var afterDone = function (d) {
                        var hItem = '<li class="list-group-item"><a href="/admin/settings/email/custom/' + d.id + '">  ' + d.name + ' </a><span class="listtool"><a href="#" class="btn btn-default" data-action="editGroup" data-id="' + d.id + '" data-title="' + d.name + '"><i class="fa fa-pencil" aria-hidden="true"></i></a> <a href="#" class="btn btn-default" data-action="deleteGroup" data-id="' + d.id + '"><i class="fa fa-trash-o" aria-hidden="true"></i></a></span></li>';
                        $('[data-role="grouplist"]').append(hItem);
                        $("#addnewGroup").collapse("hide");
                        $('.loadinanimation').addClass('hide');
                    }
                    postAjax('/admin/settings/email/addgroup', {'group': getvalue}, afterDone);
                }

            })
            $('[href="#addnewGroup"]').click(function (e) {
                e.preventDefault()
                $('.loadinanimation').addClass('hide');
                $('[data-selector="newgroup"]').val('')
                $('[data-action="saveNewGroup"]').removeAttr('data-edit');
            })

            $('body').on('click', '[data-action="editGroup"]', function (e) {
                e.preventDefault()
                $("#addnewGroup").collapse("show");
                $('[data-role="grouplist"] li').removeClass('editActive');
                $(this).closest('li').addClass('editActive')
                $('.loadinanimation').addClass('hide');
                $('[data-action="saveNewGroup"]').attr('data-edit', $(this).data('id'))
                $('[data-selector="newgroup"]').val($(this).data('title'))
            })

            $('body').on('click', '[data-action="deleteGroup"]', function (e) {
                e.preventDefault()
                var ids = $(this).data('id')
                var alferdone = function () {
                    window.location = "/admin/settings/email/custom";
                }
                postAjax('/admin/settings/email/deletegroup', {'group': ids}, alferdone);
            })
        });
    </script>
@stop 
