<!--general settings-->
<div class="panel panel-default">
  <div class="panel-heading">General Settings</div>
  <div class="panel-body">
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label class="lableTitle">Show preview</label>
          {!! Form::select('settings[show_preview]', array('false' => 'False', 'true' => 'True'), @$settings['show_preview'],['class'=>'form-control', 'data-look' => 'showPreview']) !!} </div>
        <div class="form-group">
          <label  class="lableTitle">Show caption</label>
          {!! Form::select('settings[show_caption]', array('false' => 'False', 'true' => 'True'), @$settings['show_caption'],['class'=>'form-control', 'data-look' => 'showCaption']) !!} </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label class="lableTitle">Show Cancel</label>
          {!! Form::select('settings[show_Cancel]', array('false' => 'False', 'true' => 'True'), @$settings['show_Cancel'],['class'=>'form-control', 'data-look' => 'showCancel']) !!} </div>
        <div class="form-group">
          <label class="lableTitle">Preview File Type</label>
          {!! Form::select('settings[previewFileType]', array('image' => 'image', 'text' => 'text', 'any' => 'any'), @$settings['previewFileType'],['class'=>'form-control', 'data-look' => 'previewFileType']) !!} </div>
      </div>
    </div>
  </div>
</div>


<div class="panel panel-default">
  <div class="panel-heading">Browse Button</div>
  <div class="panel-body">
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label class="lableTitle">Browse Button  Label</label>
          {!! Form::text('settings[browseLabel]',  @$settings['browseLabel'], ['class'=>'form-control', 'data-look' => 'browseLabel']) !!} </div>
        <div class="form-group">
          <label  class="lableTitle">Browse Button Icon</label>
          <br>
          <span class="iconView" data-iconSeting="">No Icon</span> <a href="#" class="btn btn-default btn-sm" data-icon="iconbutton">Select Icon</a> {!! Form::text('settings[browseIcon]',  @$settings['browseIcon'],['class'=>'form-control iconvalhtml hide', 'data-look' => 'browseIcon']) !!} </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label class="lableTitle">Browse Button Class</label>
          {!! Form::select('settings[browseClass]', array('btn btn-default' => 'Default', 'btn btn-primary' => 'Primary', 'btn btn-success' => 'Success', 'btn btn-info' => 'Info', 'btn btn-warning' => 'Warning', 'btn btn-danger' => 'Danger' ), @$settings['browseClass'],['class'=>'form-control', 'data-look' => 'browseClass']) !!} </div>
        <div class="form-group">
          <label class="lableTitle">Browse Button width</label>
          {!! Form::select('settings[browsewidth]', array('default' => 'Default', 'btn-block' => 'block - Full width' ), @$settings['browsewidth'],['class'=>'form-control', 'data-look' => 'browsewidth']) !!} </div>
      </div>
    </div>
  </div>
</div>

<!--Upload Button-->

<div class="panel panel-default">
  <div class="panel-heading">Upload Button</div>
  <div class="panel-body">
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label class="lableTitle">Show upload</label>
          {!! Form::select('settings[show_upload]', array('false' => 'False', 'true' => 'True'),  @$settings['show_upload'],['class'=>'form-control', 'data-look' => 'showUpload']) !!} </div>
        <div class="form-group">
          <label  class="lableTitle">Upload Button  Icon</label>
          <br>
          <span class="iconView" data-iconSeting="">No Icon</span> <a href="#" class="btn btn-default btn-sm" data-icon="iconbutton">Select Icon</a> {!! Form::text('settings[uploadIcon]', @$settings['uploadIcon'],['class'=>'form-control iconvalhtml hide', 'data-look' => 'uploadIcon']) !!} </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label  class="lableTitle">Upload Button Label</label>
          {!! Form::text('settings[uploadLabel]', @$settings['uploadLabel'],['class'=>'form-control', 'data-look' => 'uploadLabel']) !!} </div>
        <div class="form-group">
          <label  class="lableTitle">Upload Button Class</label>
          {!! Form::select('settings[uploadClass]', array('btn btn-default' => 'Default', 'btn btn-primary' => 'Primary', 'btn btn-success' => 'Success', 'btn btn-info' => 'Info', 'btn btn-warning' => 'Warning', 'btn btn-danger' => 'Danger' ), @$settings['uploadClass'],['class'=>'form-control', 'data-look' => 'uploadClass']) !!} </div>
      </div>
    </div>
  </div>
</div>

<!--Remove Button-->

<div class="panel panel-default">
  <div class="panel-heading">Remove Button</div>
  <div class="panel-body">
    <div class="row">
      <div class="col-sm-6">
        <div class="form-group">
          <label class="lableTitle">Show Remove</label>
          {!! Form::select('settings[show_remove]', array('false' => 'False', 'true' => 'True'), @$settings['show_remove'],['class'=>'form-control', 'data-look' => 'showRemove']) !!} </div>
        <div class="form-group">
          <label  class="lableTitle">Remove Button Icon</label>
          <br>
          <span class="iconView" data-iconSeting="">No Icon</span> <a href="#" class="btn btn-default btn-sm" data-icon="iconbutton">Select Icon</a> {!! Form::text('settings[removeIcon]', @$settings['removeIcon'],['class'=>'form-control iconvalhtml hide', 'data-look' => 'removeIcon']) !!} </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group">
          <label class="lableTitle">Remove Button Label</label>
          {!! Form::text('settings[removeLabel]',  @$settings['removeLabel'],['class'=>'form-control', 'data-look' => 'removeLabel']) !!} </div>
        <div class="form-group">
          <label class="lableTitle">Remove Button  Class </label>
          {!! Form::select('settings[removeClass]', array('btn btn-default' => 'Default', 'btn btn-primary' => 'Primary', 'btn btn-success' => 'Success', 'btn btn-info' => 'Info', 'btn btn-warning' => 'Warning', 'btn btn-danger' => 'Danger' ), @$settings['removeClass'],['class'=>'form-control', 'data-look' => 'removeClass']) !!} </div>
      </div>
    </div>
  </div>
</div>

<a href="#" class="btn btn-default btn-sm hide" id="icons">Edit</a> 