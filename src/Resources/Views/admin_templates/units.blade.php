@extends('cms::layouts.mTabs',['index'=>'backend_settings'])
<!-- Nav tabs -->
@section('tab')
    {!! HTML::style('app/Modules/Uploads/Resources/assets/css/new-store.css') !!}
    <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cms_module_list">
            <h3 class="menuText f-s-17 hide">
                <span class="module_icon_main"></span>
                <span class="module_icon_main_text">Units</span>
            </h3>
            <div class=" menuBox">
                <a href="#" class="btn btn-danger addBtn"><i class="fa fa-plus"></i></a>
                <div class="selectCat">
                    {!! Form::select('type',$types,$type,['class' => 'selectpicker select-type','data-style' => 'selectCatMenu',' data-width' => '100%']) !!}
                </div>
            </div>
            <hr>
            <ul class="list-unstyled menuList" id="components-list">
                @if(count($ui_elemements))
                    @foreach($ui_elemements as $ui)
                        @if($unit)
                            @if($unit->slug == $ui->slug)
                                <li class="active">
                            @else
                                <li class="">
                            @endif
                        @else
                            @if($ui_elemements[0]->slug == $ui->slug)
                                <li class="active">
                            @else
                                <li class="">
                                    @endif
                                    @endif
                                    <a href="?p={!! $ui->slug !!}{!! ($type)? "&type=".$type : "" !!}" rel="unit"
                                       data-slug="{{ $ui->slug }}" class="tpl-left-items">
                                        <span class="module_icon"></span> {{ $ui->title }}
                                    </a>
                                </li>
                                @endforeach
                                @else
                                    No Units
                                @endif
            </ul>
        </div>


        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
            <div class="row">
                <div class="col-xs-12 col-sm-12 unit-box">
                    @include('settings::admin_templates._partials.unit_box')
                </div>
            </div>
            <div class="row template-search">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 template-search-box m-t-10 m-b-10">
                    <form class="form-horizontal">
                        <div class="form-group m-b-0  ">
                            <label for="inputEmail3" class="control-label text-left"><i
                                        class="fa fa-sort-amount-desc"></i> Sort By</label>
                            <select class="selectpicker" data-style="selectCatMenu" data-width="50%">
                                <option>Recently Added</option>
                            </select>

                        </div>
                    </form>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 p-l-0 p-r-0">
                    <div class="template-upload-button clearfix">
                        <div class="rightButtons">
                            <div class="btn-group listType">
                                <a href="#" class="btn btnListView"><i class="fa fa fa-th-list"></i></a>
                                <a href="#" class="btn btnGridView active"><i class="fa fa-th-large"></i></a>
                            </div>
                            <a class="btn btn-default searchBtn"><i class="fa fa-search " aria-hidden="true"></i></a>
                        </div>

                        <ul class="editIcons list-unstyled ">
                            <li><a href="#" class="btn trashBtn"><i class="fa fa-trash-o"></i></a></li>
                            <li><a href="#" class="btn copyBtn"><i class="fa fa-clone"></i></a></li>
                            <li><a href="#" class="btn editBtn"><i class="fa fa-pencil"></i></a></li>
                        </ul>

                        <button class="btn btn-sm pull-right btnUploadWidgets" type="button" data-toggle="modal"
                                data-target="#uploadfile">
                            <i class="fa fa-cloud-upload module_upload_icon"></i> <span class="upload_module_text">Upload Widgets</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="templates-list  m-t-20 m-b-10">
                <div class="row m-b-10">
                    {!! HTML::image('resources/assets/images/ajax-loader5.gif', 'a picture', array('class' => 'thumb img-loader hide')) !!}
                    <div class="raw tpl-list">
                        @include('settings::admin_templates._partials.unit_variations')
                    </div>
                </div>
            </div>

            <div class="loadding"><em class="loadImg"></em></div>
            <nav aria-label="" class="text-center">
                <ul class="pagination paginationStyle">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item active">
                        <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
            <div class="text-center">
                <button type="button" class="btn btn-lg btn-primary btnLoadmore"><em class="loadImg"></em> Load more
                </button>
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
                    {!! Form::open(['url'=>'/admin/resources/units/upload-unit','class'=>'dropzone', 'id'=>'my-awesome-dropzone']) !!}
                    {!! Form::hidden('data_type','files',['id'=>"dropzone_hiiden_data"]) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        @include('resources::assests.deleteModal',['title'=>'Delete Widget'])
    </div>
@stop
@section('CSS')
    {!! HTML::style('js/bootstrap-select/css/bootstrap-select.min.css') !!}
    <style>
        .child-tpl {
            width: 95% !important;
        }

        .img-loader {
            width: 70px;
            height: 70px;
            position: absolute;
            top: 50px;
            left: 40%;
        }

    </style>
@stop
@section('JS')
    {!! HTML::script('js/dropzone/js/dropzone.js') !!}
    {!! HTML::script('js/bootstrap-select/js/bootstrap-select.min.js') !!}
    <script>
        Dropzone.options.myAwesomeDropzone = {
            init: function () {
                this.on("success", function (file) {
                    location.reload();

                });
            }
        };

        $(document).ready(function () {

            $('body').on("change", ".select-type", function () {
                var val = $(this).val();
                var url = window.location.pathname + "?type=" + val;

                window.location = url;
            });

            $('.rightButtons a').click(function (e) {
                e.preventDefault();
                $(this).addClass('active').siblings().removeClass('active');
            });

            $('.btnListView').click(function (e) {
                e.preventDefault();
                $('#viewType').addClass('listView');
            });

            $('.btnGridView').click(function (e) {
                e.preventDefault();
                $('#viewType').removeClass('listView');
            });


            $('.selectpicker').selectpicker();

            var p = "{!! $_GET['p'] or null !!}";
//            $('body').on('click','.del-tpl',function(){
//                var slug = $(this).attr('slug');
//                $.ajax({
//                    url: '/admin/resources/widgets/delete',
//                    data: {
//                        slug: slug
//                    },headers: {
//                        'X-CSRF-TOKEN':$("input[name='_token']").val()
//                    },
//                    dataType: 'json',
//                    success: function (data) {
//                        // location.reload();
//
//                    },
//                    type: 'POST'
//                });
//            });


//            $('.tab-content').on('click','.delete_layout', function () {
//                console.log(1);
//                var key = $(this).attr('data-key');
//                $('.delete_modal .modal-footer a')
//                        .attr('href', '#')
//                        .attr('slug', $(this).attr('data-key'))
//                        .addClass('del-tpl');
//                $('.modal-body').html("<p>atre you sure you want to delete Widget <b>" + $(this).attr('data-title') + '<b> ?');
//                $('.delete_modal').modal();
//            });

            //Change browser url without page reloading with ajax request

//            $("a[rel='unit']").click(function(e){
//                e.preventDefault();
//                var main_type = $(this).attr('main-type');
//                var pageurl = $(this).attr('href');
//                $('.tpl-left-items').parent().removeClass('active');
//                var general_type = $(this).attr('type');
//
//                if(general_type){
//                    $('*[main-type="'+general_type+'"]').parent().addClass('active');
//                    $('*[main-type="'+ main_type +'"][type="'+general_type+'"]').parent().addClass('active');
//                }else{
//                    $('*[main-type="'+ main_type +'"]').parent().addClass('active');
//                }
//
//                $.ajax({
//                    url: '/admin/resources/widgets/widget-with-type',
//                    data: {
//                        main_type: main_type,
//                        url:pageurl+'?rel=tab',
//                        type: general_type
//                    },headers: {
//                        'X-CSRF-TOKEN':$("input[name='_token']").val()
//                    },
//                    dataType: 'json',
//                    beforeSend: function () {
//                        $('.tpl-list').html('');
//                        $('.img-loader').removeClass('hide');
//                    },
//                    success: function (data) {
//
//                        $('.img-loader').addClass('hide');
//                        if (!data.error) {
//                            $('.tpl-list').html(data.html);
//                        }
//                    },
//                    type: 'POST'
//                });
//                if(pageurl!=window.location){
//                    window.history.pushState({path:pageurl},'',pageurl);
//                }
//                return false;
//            });

            $("a[main-type=" + p + "]").click();


        });

    </script>
@stop
