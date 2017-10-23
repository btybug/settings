@extends('layouts.admin')
@section('content')
    {!! Breadcrumbs::render('settings_emailtpl_edit') !!}
    {!! Form::open(['route' => 'system.email.save','method' => 'post','class' => 'form-horizontal']) !!}
    <div class="clearfix">
        <table class="table borderless m-0">
            <tr>
                <td>
                    <div class="p-t-5">Title</div>
                </td>
                <td>{!! Form::text('name',$email->name,['class' => 'form-control', 'id' => 'name' ,'placeholder' => 'name']) !!}</td>
                <td><input type="submit" class="btn btn-success pull-right m-b-10 p-r-30 p-l-30" value="Save"></td>
            </tr>
        </table>
    </div>
    <div class="col-md-9 p-0">
        <div class="panel panel-default" data-sortable-id="ui-typography-7">
            <div class="panel-heading bg-black-darker text-white">Email Content</div>
            <div class="panel-body p-5"> {!! Form::hidden('email_id',$email->id) !!}
                <table class="table borderless m-0">
                    <tr>
                        <td width="15%">
                            <div class="p-5">From</div>
                        </td>
                        <td width="85%">{!! Form::select('from_',$from, @$email->from_,['class'=>'form-control','id'=>'layout']) !!}</td>
                    </tr>
                    <tr>
                        <td width="15%">
                            <div class="p-5">To</div>
                        </td>
                        <td width="85%">@if(isset($settings['to_']) || $email->is_public==0 )
                                <div class="bg-silver p-10">{!! ($email->to_!='')?$email->to_:'N/A'!!}</div>
                            @else
                                <div class="input-group">
                                    <input name="to_" class="form-control hide" data-tagit="tagit" type="text"
                                           value="{!! $email->to_ !!}">
                                    <div class="input-group-addon addonNone" data-toggle="tooltip"
                                         data-placement="right" title="{!! $to !!}"><i class="fa fa-info-circle fa-lg"
                                                                                       aria-hidden="true"></i></div>
                                </div>
                            @endif </td>
                    </tr>

                    <tr>
                        <td width="15%">
                            <div class="p-5">Notify To</div>
                        </td>
                        <td width="85%">
                            @if(isset($settings['notify_to']) || $email->is_public==0 )
                                <div class="bg-silver p-10">{!! ($email->notify_to!='')?$email->notify_to:'N/A'!!}</div>
                            @else
                                <div class="input-group">
                                    <input name="notify_to" class="form-control hide" data-tagit="tagit" type="text"
                                           value="{!! $email->notify_to !!}">
                                    <div class="input-group-addon addonNone" data-toggle="tooltip"
                                         data-placement="right" title="{!! $to !!}"><i class="fa fa-info-circle fa-lg"
                                                                                       aria-hidden="true"></i></div>
                                </div>
                            @endif

                        </td>
                    </tr>

                    <tr>
                        <td width="15%">
                            <div class="p-5">CC</div>
                        </td>
                        <td width="85%">
                            @if(isset($settings['cc']) || $email->is_public==0 )
                                <div class="bg-silver p-10">{!! ($email->cc!='')?$email->cc:'N/A'!!}</div>
                            @else
                                <div class="input-group">
                                    <input name="cc" class="form-control hide" data-tagit="tagit" type="text"
                                           value="{!! $email->cc !!}">
                                    <div class="input-group-addon addonNone" data-toggle="tooltip"
                                         data-placement="right" title="{!! $to !!}"><i class="fa fa-info-circle fa-lg"
                                                                                       aria-hidden="true"></i></div>
                                </div>
                            @endif

                        </td>
                    </tr>

                    <tr>
                        <td width="15%">
                            <div class="p-5">BCC</div>
                        </td>
                        <td width="85%">
                            @if(isset($settings['bcc']) || $email->is_public==0 )
                                <div class="bg-silver p-10">{!! ($email->bcc!='')?$email->bcc:'N/A'!!}</div>
                            @else
                                <div class="input-group">
                                    <input name="bcc" class="form-control hide" data-tagit="tagit" type="text"
                                           value="{!! $email->bcc !!}">
                                    <div class="input-group-addon addonNone" data-toggle="tooltip"
                                         data-placement="right" title="{!! $to !!}"><i class="fa fa-info-circle fa-lg"
                                                                                       aria-hidden="true"></i></div>
                                </div>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td width="15%">
                            <div class="p-5">Reply To</div>
                        </td>
                        <td width="85%">
                            {!! Form::select('replyto',$from, @$email->replyto,['class'=>'form-control','id'=>'layout']) !!}
                        </td>
                    </tr>


                    <tr>
                        <td width="15%">
                            <div class="p-5">Subject</div>
                        </td>
                        <td width="85%">{!! Form::text('subject',$email->subject,['class' => 'form-control', 'id' => 'subject' ,'placeholder' => 'subject']) !!}</td>
                    </tr>
                    <tr>
                        <td width="15%">
                            <div class="p-5">Attachment</div>
                        </td>
                        <td width="85%">
                            <button class="btn btn-default" type="button" data-role="browseMediabutton">Browse Media
                            </button>
                            <span class="m-l-10">{!! class_basename($email->attachment) !!}</span>
                            <input class="form-control fileParth" type="hidden" hidden="hidden" name="attachment"
                                   value="{!! $email->attachment !!}">
                        </td>
                    </tr>


                    <tr id="editor">
                        <td valign="top">
                            <div class="p-5">Content</div>
                        </td>
                        <td>
                            {!! Form::textarea('content',$email->content,['id' => 'contentEditor'] ) !!}
                        </td>
                    </tr>

                </table>
            </div>
        </div>
    </div>
    <div class="col-md-3 p-0 p-l-5">
        <div class="panel panel-default" data-sortable-id="ui-typography-7">
            <div class="panel-heading bg-black-darker text-white">Content</div>
            <div class="panel-body p-5">
                <table class="table borderless m-0">
                    <tr>
                        <td>
                            <div class="p-b-5">Content Type</div>
                            @if(isset($settings['content_type']) || $email->is_public==0 )
                                <div class="bg-silver p-10">{!! ($email->content_type!='')?$email->content_type:'N/A'!!}</div>
                            @else
                                {!! Form::select('content_type',$content_type,$email->content_type,['class'=>'form-control','id'=>'content_type']) !!}
                            @endif
                        </td>
                    </tr>
                    <tr class="template">
                        <td>
                            <div class="p-b-5">Templates</div>
                            {!! Form::select('template_id',$templates,$email->template_id,['class'=>'form-control','id'=>'template']) !!}
                        </td>
                    </tr>
                    <tr class="template-var" style="display:none">
                        <td>
                            <div class="p-b-5">Variations</div>
                            {!! Form::select('variation_id',$variations,$email->variation_id,['class'=>'form-control','id'=>'variation_id']) !!}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="panel panel-default" data-sortable-id="ui-typography-7">
            <div class="panel-heading bg-black-darker text-white">Event and Time</div>
            <div class="panel-body p-5">
                <table class="table borderless m-0">

                    <tr>
                        <td>
                            <div class="p-b-5">Event / Trigger</div>
                            @if($email->is_public == 1)
                                {!! Form::select('event_code',$events,$email->event_code,['class'=>'form-control','id'=>'layout']) !!}
                            @else
                                <div class="bg-silver-lighter p-10"> {!! $events[$email->event_code] !!}</div>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="p-b-5">When</div>
                            @if(isset($settings['when_']) || $email->is_public==0 )
                                <div class="bg-silver-lighter p-10"> {!! $email->when_ !!}</div>
                            @else
                                {!! Form::select('when_', array('immediate' => 'Immediate', 'custom_time' => 'Custom Time'), $email->when_, ['class'=>'form-control','id'=>'when_', 'data-change'=>'afterday']) !!}
                            @endif
                        </td>
                    </tr>
                    <tr data-container="afterday" class="hide">
                        <td>
                            <div class="p-b-5">After Days</div>
                            {!! Form::select('custom_days', array('1' => '1 Day', '3' => '3 Days','5' => '5 Days' ,'10' => '10 Days','15' => '15 Days','30' => '30 Days','0' => 'Custom Date'), $email->custom_days, ['class'=>'form-control','id'=>'afterday', 'data-change'=>'settime']) !!}
                        </td>
                    </tr>
                    <tr data-container="settime" class="hide">
                        <td>
                            <div class="p-b-5">Select Date</div>
                            <div class='input-group date' data-actions="Timercalendar">
                                <input name="custom_time" class="form-control" type="text"
                                       value="{!!  $email->custom_time !!}">
                                <span class="input-group-addon"> <i class="fa fa-calendar"
                                                                    aria-hidden="true"></i> </span></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="panel panel-default" data-sortable-id="ui-typography-7">
            <div class="panel-heading bg-black-darker text-white">Available Codes</div>
            <div class="panel-body p-5">
                <table class="table borderless m-0">
                    <tr>
                        <td>
                            <div class="m-b-5">[mail_receiver_user_name]</div>
                            <div class="m-b-5">[mail_receiver_last_name]</div>
                            <div class="m-b-5">[mail_receiver_email]</div>
                            <div class="m-b-5">[Edate]</div>
                            <div class="m-b-5">[logo]</div>
                            <div class="m-b-5">[mail_receiver_last_name or=username]</div>
                            <div class="m-b-5">[site_name]</div>

                            @if($email->form)
                                <hr>
                                <div class="m-b-5">data from form fields</div>
                                @foreach($email->form->fields as $field)
                                    @if($field->field_type->input_type!='password')
                                        <div class="m-b-5">[field name={!! $field->name !!}]</div>
                                    @endif
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    {!! Form::close() !!}


@stop
@section('CSS')
    {!! HTML::style('/public/libs/tag-it/css/jquery.tagit.css') !!}
    {!! HTML::style('/public/libs/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css') !!}
    <style>
        .input-group-addon.addonNone {
            background: none;
            border: 0;
            box-shadow: none
        }
    </style>
@stop

@section('JS')
    {!! HTML::script('/public/editor/tinymice/tinymce.min.js') !!}
    {!! HTML::script('/public/libs/tag-it/js/tag-it.js') !!}
    {!! HTML::script('/public/libs/bootstrap-datetimepicker/js/moment.min.js') !!}
    {!! HTML::script('/public/libs/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') !!}
    {!! HTML::script('public/libs/bootbox/js/bootbox.min.js') !!}
    <script>

        tinymce.init({
            selector: 'textarea#contentEditor',
            height: 500,
            theme: 'modern',
            plugins: [
                'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                'searchreplace wordcount visualblocks visualchars code fullscreen',
                'insertdatetime media nonbreaking save table contextmenu directionality',
                'emoticons template paste textcolor colorpicker textpattern imagetools'
            ],
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
            toolbar2: 'print preview media | forecolor backcolor emoticons',
            image_advtab: true,

        });

        $(document).ready(function () {
            //mngContent();
            if ($('[data-role="browseMediabutton"]').length > 0) {
                $('[data-role="browseMediabutton"]').media();
            }
        });
        var tagdatasorce = '{!! $to !!}';
        $('[data-tagit="tagit"]').each(function () {
            var getExt = tagdatasorce.split(',');
            $(this).tagit({
                availableTags: getExt

            });

        })
        $('[data-toggle="tooltip"]').tooltip()
        $('#content_type').change(function () {
            mngContent();
        });

        $('[data-change]').change(function () {
            settimeshow()
        })

        function settimeshow() {
            var thisvar = $('[data-change="afterday"]').val()
            if (thisvar == "custom_time") {
                $('[data-container="afterday"]').removeClass('hide')
            } else {
                $('[data-container="afterday"]').addClass('hide')
                $('[data-container="settime"]').addClass('hide');
                return false;
            }

            var costomday = $('[data-change="settime"]').val()
            if (costomday == "0") {
                $('[data-container="settime"]').removeClass('hide')
            } else {
                $('[data-container="settime"]').addClass('hide')
            }
        }

        settimeshow();

        $('[data-actions="Timercalendar"]').datetimepicker({
            viewMode: 'days',
            format: 'DD/MM/YYYY'
        });

        function mngContent() {
            val = $('#content_type').val();
            if (val == 'template') {
                $('.template').show();
                var afte = function (d) {
                    tinyMCE.activeEditor.setContent(d.data);
                }
                getAjax('/admin/templates/template', {'tpl_id': $("#template").val()}, afte);
            } else {
                $('.template').hide();
                tinyMCE.activeEditor.setContent('');
            }

        }

        $("#template").change(function () {
            changeTpl();
        });

        function changeTpl() {
            var updatevariation = function (d) {
                $("#variation_id").empty().append(d);
            }
            getAjax('/admin/templates/tplvariationdd', {'tpl_id': $("#template").val()}, updatevariation);
        }


    </script>
@stop 
