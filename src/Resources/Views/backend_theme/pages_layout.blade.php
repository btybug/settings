
@extends('cms::layouts.mTabs',['index'=>'backend_theme'])
@section('tab')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="row template-search">
                <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9 template-search-box m-t-10 m-b-10">
                    <form class="form-horizontal">
                        <div class="form-group m-b-0">
                            <label for="inputEmail3" class="col-sm-2 control-label">Sort By</label>
                            <div class="col-sm-4">
                                <select class="form-control">
                                    <option>Recently Added</option>
                                </select>
                            </div>
                            <div class="col-sm-2 pull-right">
                                <a class="btn btn-default"><i class="fa fa-search f-s-15" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 template-upload-button p-l-0 p-r-0">
                    <button class="btn btn-sm  pull-right m-b-10 " type="button" data-toggle="modal" data-target="#uploadfile">
                        <span class="module_upload_icon m-l-20"></span> <span class="upload_module_text">Upload</span>
                    </button>
                </div>
            </div>
            <div class="templates-list  m-t-20 m-b-10">
                @if(!is_null($layouts))
                @foreach($layouts as $layout)
                <div class="row templates m-b-10">
                    {!! HTML::image('public/img/ajax-loader5.gif', 'a picture', array('class' => 'thumb img-loader hide')) !!}
                    <div class="raw tpl-list">
                        <div class="row templates m-b-10">
                            <div class="col-xs-12 p-l-0 p-r-0">
                                @if(isset($layout->image))
                                    <img src="{!! url('resources/templates/'.$layout->type.'/'.$layout->slug. '/images/'. $layout->image)!!}"  style="height: 167px;" class="img-responsive"/>
                                @else
                                    <img src="{!! url('resources/assets/images/template-2.png')!!}" class="img-responsive"/>
                                @endif
                            </div>
                            <div class="col-xs-12 templates-header p-t-10 p-b-10">
                                <span class="pull-left templates-title f-s-15 col-xs-6 col-sm-6 col-md-6 col-lg-6 p-l-0  "><i class="fa fa-bars f-s-13 m-r-5" aria-hidden="true"></i>  {!! $layout->name !!} </span>
                                <div class="pull-right templates-buttons col-xs-6 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right ">
                                    <i class="fa fa-user f-s-13 author-icon" aria-hidden="true"></i>
                                    author:{!! $layout->author !!} , {!! BBgetDateFormat($layout->created_at) !!}
                                    <a href="#" class="addons-deactivate  m-r-10"><i class="fa fa-pencil f-s-14"></i> </a>
                                    <a href="{!! url('/admin/backend/pages-layout/settings',$layout->slug) !!}" class="addons-deactivate  m-r-10"><i class="fa fa-cog f-s-14"></i> </a>
                                    <a href="{!! url('/admin/backend/pages-layout/delete',$layout->slug) !!}" data-href="{!! url('/admin/backend/pages-layout/delete',$layout->slug) !!}" slug="#" class="addons-delete del-tpl"><i class="fa fa-trash-o f-s-14 "></i> </a>

                                </div>
                            </div>
                            </div>

                        @endforeach
                    @else
                        <div class="col-xs-12 addon-item">
                            NO Templates
                        </div>
                    @endif









































            </div>

        </div>
    </div>
    <div class="modal fade" id="uploadfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Upload</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['url'=>'/admin/settings/upload-layout','class'=>'dropzone', 'id'=>'my-awesome-dropzone']) !!}

                    {!! Form::close() !!} </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@stop
@section('CSS')
    {!! HTML::style('/app/Modules/Assets/Resources/css/new-store.css') !!}
@stop
@section('JS')
    {!! HTML::script('public/libs/dropzone/js/dropzone.js') !!}

    <script>
        $(document).ready(function () {
            Dropzone.options.myAwesomeDropzone = {
                init: function () {
                    this.on("success", function (file) {
                        location.reload();
                    });
                }
            };
        });
        </script>

@stop
