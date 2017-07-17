<div class="form-horizontal">
    
    <div class="form-group">
        <label class="control-label col-sm-12 text-left p-b-10">Uploader Type</label>
        <div class="col-sm-12">
        {!! Form::select('uploader_type',['backend_media'=>'Admin Uploader ( Media )','backend'=>'Admin Uploader ( Custom )','frontend'=>'Front Uploader'], null, ['class' => 'form-control','id'=>'uploader_type']) !!} 
        </div>
    </div>
    
    <div class="form-group dd" id="0">
        <label class="control-label col-sm-12 text-left p-b-10">Media Folders</label>
        <div class="col-sm-12">
        {!! Form::select('uploader_type',$folders, null, ['class' => 'form-control']) !!} 
        </div>
    </div>
    
    <div class="form-group dd" id="1">
        <label class="control-label col-sm-12 text-left p-b-10">Custom Folders</label>
        <div class="col-sm-12">
        {!! Form::select('uploader_type',[''=>' Select Folder ','upload_module'=>'Upload Module','upload_widget'=>'Upload Widget','upload_template'=>'Upload Template'], null, ['class' => 'form-control ']) !!} 
        </div>
    </div>

    
    <div class="form-group">
       <label class="control-label col-sm-12 text-left p-b-10 f-w-100">Allow Multiple {!! Form::checkbox('allow_multiple','1', false, ['id' => 'allow_chk']) !!}</label>
       <div id="min_max">
          <div class="col-md-6">
            <label class="control-label  text-left p-b-10">Min </label>
            {!! Form::text('min',null,['class'=>'form-control','placeholder'=>'e.g. 1,3,5']) !!}
          </div>
          <div class="col-md-6">
          <label class="control-label text-left p-b-10">Max </label>
          {!! Form::text('max',null,['class'=>'form-control','placeholder'=>'e.g. 1,3,5']) !!}
          </div>
           
       </div>
</div>
</div>