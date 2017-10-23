@extends('layouts.admin')
@section('content')
    {!! Breadcrumbs::render('settings_nitify_edit') !!}
    {!! Form::model($model,['url' => 'admin/settings/system/notifications/edit-cat','method' => 'post','class' => 'form-horizontal']) !!}


    <div class="col-md-10 p-0">
        <div class="panel panel-default" data-sortable-id="ui-typography-7">
            <div class="panel-heading bg-black-darker text-white">Notification Settings For &nbsp;
                <b>{!! $model->name!!}</b></div>
            <div class="panel-body p-5"> {!! Form::hidden('id',$model->id) !!}
                <table class="table borderless m-0">

                    <tr>
                        <td width="18%">
                            <div class="p-5">Active</div>
                        </td>
                        <td width="82%">

                            {!! Form::checkbox('is_active', 1, null,['class'=>'chkbx','data-on-text'=>'Yes','data-off-text'=>'No','data-off-color'=>'danger']) !!}

                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="p-t-5">Type</div>
                        </td>
                        <td>
                            {!! Form::select('type', ['primary'=>'Primary', 'info'=>'Info', 'success'=>'Success', 'warning'=>'Warning', 'danger'=>'Danger'], null, ['class' => 'form-control']) !!}
                        </td>
                    </tr>

                    <tr>
                        <td width="18%">
                            <div class="p-5">Sender</div>
                        </td>
                        <td width="82%">
                            {!! Form::select('sender',$from, null,['class'=>'form-control','id'=>'layout']) !!}
                        </td>
                    </tr>

                    <tr>
                        <td width="18%">
                            <div class="p-5">Receiver</div>
                        </td>
                        <td width="82%">

                            <input name="receivers" class="form-control hide" data-tagit="tagit" type="text"
                                   value="{!! $model->receivers !!}">

                        </td>
                    </tr>

                    <tr>
                        <td width="18%">
                            <div class="p-5">Send Email</div>
                        </td>
                        <td width="82%">{!! Form::checkbox('send_mail', 1, null,['class'=>'chkbx','data-on-text'=>'Yes','data-off-text'=>'No','data-off-color'=>'danger']) !!}</td>
                    </tr>


                    <tr>
                        <td width="18%">
                            <div class="p-5">Email Template</div>
                        </td>
                        <td width="82%">

                            {!! Form::select('email_tpl', ['Cho'=>'Choose Email Template'], null, ['class' => 'form-control']) !!}

                        </td>
                    </tr>

                    <tr>
                        <td width="18%">
                            <div class="p-5">Associate To Event</div>
                        </td>
                        <td width="82%">

                            {!! Form::checkbox('send_mail', 1, null,['class'=>'chkbx','data-on-text'=>'Yes','data-off-text'=>'No','data-off-color'=>'danger']) !!}

                        </td>
                    </tr>

                    <tr>
                        <td width="18%">
                            <div class="p-5">Choose Event</div>
                        </td>
                        <td width="82%">

                            {!! Form::select('email_tpl', ['Cho'=>'Choose Event'], null, ['class' => 'form-control']) !!}

                        </td>
                    </tr>


                    <tr>
                        <td width="18%">
                            <div class="p-5">Text</div>
                        </td>
                        <td width="82%">{!! Form::textarea('text',null,['class' => 'form-control', 'size' => '30x5']) !!}</td>
                    </tr>
                    <tr>
                        <td width="18%"></td>
                        <td width="82%"><input type="submit" class="btn btn-success p-r-30 p-l-30" value="Save"></td>
                    </tr>


                </table>
            </div>
        </div>
    </div>


    {!! Form::close() !!}


@stop
@section('CSS')
    {!! HTML::style('/public/libs/tag-it/css/jquery.tagit.css') !!}
    {!! HTML::style('/public/libs/select2/css/select2.min.css') !!}
    {!! HTML::style('/public/libs/bootstrap-switch/css/bootstrap-switch.min.css') !!}
@stop
@section('JS')
    {!! HTML::script('/public/libs/tag-it/js/tag-it.js') !!}
    {!! HTML::script('/public/libs/select2/js/select2.min.js') !!}
    {!! HTML::script('public/libs/bootstrap-switch/js/bootstrap-switch.min.js') !!}
    <script>
        $(".chkbx").bootstrapSwitch();

        $("select").select2();
        var tagdatasorce = '{!! $to !!}';
        $('[data-tagit="tagit"]').each(function () {
            var getExt = tagdatasorce.split(',');
            $(this).tagit({
                availableTags: getExt

            });

        })
    </script>


@stop 