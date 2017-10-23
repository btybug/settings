<div class="form-horizontal">
    <div class="form-group">
        <label class="control-label col-sm-12 p-b-5 text-left f-w-100">Small Thumbnail Size</label>
        <div class="col-sm-4">
            {!! Form::text('thumb[small_w]',@$thumb['small_w'],['class'=>'form-control','placeholder'=>'Small Thumb Width']) !!}
        </div>
        <div class="pull-left m-t-5"><strong>x</strong></div>
        <div class="col-sm-4">
            {!! Form::text('thumb[small_h]',@$thumb['small_h'],['class'=>'form-control','placeholder'=>'Small Thumb Height']) !!}
        </div>
        <div class="col-sm-1 p-l-0 m-t-5"><strong>Px</strong></div>
    </div>

    <div class="form-group">
        <label for="upload_size" class="control-label col-sm-12 p-b-5 text-left f-w-100">Medium Thumbnail Size:</label>

        <div class="col-sm-4">
            {!! Form::text('thumb[medium_w]',@$thumb['medium_w'],['class'=>'form-control','placeholder'=>'Medium Thumb Width']) !!}
        </div>
        <div class="pull-left m-t-5"><strong>x</strong></div>
        <div class="col-sm-4">
            {!! Form::text('thumb[medium_h]',@$thumb['medium_h'],['class'=>'form-control','placeholder'=>'Medium Thumb Height']) !!}
        </div>
        <div class="col-sm-1 p-l-0 m-t-5"><strong>Px</strong></div>
    </div>
    <div class="form-group">
        <label for="upload_size" class="control-label col-sm-12 p-b-5 text-left f-w-100">Large Thumbnail Size:</label>
        <div class="col-sm-4">
            {!! Form::text('thumb[lg_w]',@$thumb['lg_w'],['class'=>'form-control','placeholder'=>'Large Thumb Width']) !!}
        </div>
        <div class="pull-left m-t-5"><strong>x</strong></div>
        <div class="col-sm-4">
            {!! Form::text('thumb[lg_h]',@$thumb['lg_h'],['class'=>'form-control','placeholder'=>'Large Thumb Height']) !!}
        </div>
        <div class="col-sm-1 p-l-0 m-t-5"><strong>Px</strong></div>
    </div>
</div>
