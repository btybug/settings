<div role="tabpanel" class="tab-pane" id="Title_Meta">
    <ul class="nav nav-pills">
        <li class="active"><a data-toggle="tab" href="#available_codes">Avaailable Codes</a></li>
        <li><a data-toggle="tab" href="#title_format">Title Format</a></li>
        <li><a data-toggle="tab" href="#meta_description">Meta Description</a></li>
        <li><a data-toggle="tab" href="#meta_keywords">Meta Keywords</a></li>
    </ul>
    <div class="tab-content">
        <div id="available_codes" class="tab-pane fade in active">
            <div class="panel panel-default m-t-10">
                <div class="panel-body">
                    <div class="m-b-5">{site_name}</div>
                    <div class="m-b-5">{page_title}</div>
                    <div class="m-b-5">{post_title}</div>
                </div>
            </div>
        </div>

        <!--Title Format-->

        <div id="title_format" class="tab-pane fade">
            <div class="panel panel-default m-t-10">
                <div class="panel-body p-b-0">
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Home Page</label>
                        <div class="col-sm-9"> {!! Form::text('titlemeta[home_title]',@$titlemeta['home_title'],['class'=>'form-control']) !!} </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Core Pages</label>
                        <div class="col-sm-9"> {!! Form::text('titlemeta[core_page_title]',@$titlemeta['core_page_title'],['class'=>'form-control']) !!} </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Custom Pages</label>
                        <div class="col-sm-9"> {!! Form::text('titlemeta[custom_page_title]',@$titlemeta['custom_page_title'],['class'=>'form-control']) !!} </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Plugin Pages</label>
                        <div class="col-sm-9"> {!! Form::text('titlemeta[plugin_page_title]',@$titlemeta['plugin_page_title'],['class'=>'form-control']) !!} </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Section Listing Page</label>
                        <div class="col-sm-9"> {!! Form::text('titlemeta[section_listing_page_title]',@$titlemeta['section_listing_page_title'],['class'=>'form-control']) !!} </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Section Single Page</label>
                        <div class="col-sm-9"> {!! Form::text('titlemeta[section_single_page_title]',@$titlemeta['section_single_page_title'],['class'=>'form-control']) !!} </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Meta Description-->

        <div id="meta_description" class="tab-pane fade">
            <div class="panel panel-default m-t-10">
                <div class="panel-body p-b-0">
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Home Page</label>
                        <div class="col-sm-9"> {!! Form::textarea('titlemeta[home_metades]',@$titlemeta['home_metades'],['size' => '30x3','class'=>'form-control']) !!} </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Core Pages</label>
                        <div class="col-sm-9"> {!! Form::textarea('titlemeta[core_page_metades]',@$titlemeta['core_page_metades'],['size' => '30x3','class'=>'form-control']) !!} </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Custom Pages</label>
                        <div class="col-sm-9"> {!! Form::textarea('titlemeta[custom_page_metades]',@$titlemeta['custom_page_metades'],['size' => '30x3','class'=>'form-control']) !!} </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Plugin Pages</label>
                        <div class="col-sm-9"> {!! Form::textarea('titlemeta[plugin_page_metades]',@$titlemeta['plugin_page_metades'],['size' => '30x3','class'=>'form-control']) !!} </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Section Listing Page</label>
                        <div class="col-sm-9"> {!! Form::textarea('titlemeta[section_listing_page_metades]',@$titlemeta['section_listing_page_metades'],['size' => '30x3','class'=>'form-control']) !!} </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Section Single Page</label>
                        <div class="col-sm-9"> {!! Form::textarea('titlemeta[section_single_page_metades]',@$titlemeta['section_single_page_metades'],['size' => '30x3','class'=>'form-control']) !!} </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Meta Keywords-->

        <div id="meta_keywords" class="tab-pane fade">
            <div class="panel panel-default m-t-10">
                <div class="panel-body p-b-0">
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Home Page</label>
                        <div class="col-sm-9"> {!! Form::text('titlemeta[home_keyword]',@$titlemeta['home_keyword'],['class'=>'form-control']) !!} </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Core Pages</label>
                        <div class="col-sm-9"> {!! Form::text('titlemeta[core_page_keyword]',@$titlemeta['core_page_keyword'],['class'=>'form-control']) !!} </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Custom Pages</label>
                        <div class="col-sm-9"> {!! Form::text('titlemeta[custom_page_keyword]',@$titlemeta['custom_page_keyword'],['class'=>'form-control']) !!} </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Plugin Pages</label>
                        <div class="col-sm-9"> {!! Form::text('titlemeta[plugin_page_keyword]',@$titlemeta['plugin_page_keyword'],['class'=>'form-control']) !!} </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Section Listing Page</label>
                        <div class="col-sm-9"> {!! Form::text('titlemeta[section_listing_page_keyword]',@$titlemeta['section_listing_page_keyword'],['class'=>'form-control']) !!} </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label f-w-100 text-left">Section Single Page</label>
                        <div class="col-sm-9"> {!! Form::text('titlemeta[section_single_page_keyword]',@$titlemeta['section_single_page_keyword'],['class'=>'form-control']) !!} </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
