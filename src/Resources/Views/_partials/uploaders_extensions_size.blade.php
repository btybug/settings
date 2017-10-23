<div class="panel panel-default">

    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="lableTitle">Show Drag Drop Zone</label>
                    {!! Form::select('settings[show_preview]', array('false' => 'False', 'true' => 'True'), @$settings['show_preview'],['class'=>'form-control', 'data-look' => 'showPreview']) !!}
                </div>

            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="lableTitle">Drage Drop With Browse Button</label>
                    {!! Form::select('settings[show_caption]', array('false' => 'False', 'true' => 'True'), @$settings['show_caption'],['class'=>'form-control', 'data-look' => 'showCaption']) !!}
                </div>
            </div>
        </div>
    </div>
</div>