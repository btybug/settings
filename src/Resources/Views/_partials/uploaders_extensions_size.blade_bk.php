<div class="form-horizontal">
    <div class="form-group">
        <label class="control-label col-sm-12 text-left p-b-5 f-w-100">Allowed Images extensions</label>
        <div class="col-sm-12 "> {!! Form::text('img_ext',null,['class'=>'form-control imagesext imgextensions
            hide','placeholder'=>'PNG,JPG,PDF']) !!}
            <ul id="imgextensionstag" data-run-ext="images" data-ext="{{ Config('ext.images') }}"
                data-type="allowed_img_ext" class="m-b-0">
            </ul>
            <div data-ext="{{ Config('ext.images') }}" class="f-s-10 p-t-5">({{ Config('ext.images') }})</div>
        </div>
    </div>

    <div class="form-group">
        <label for="upload_size" class="control-label col-sm-12 text-left  p-b-5 f-w-100">Maximum Upload Size</label>
        <div class="col-sm-3 p-r-0"> {!! Form::text('img_ext_size',null,['class'=>'form-control','placeholder'=>'500'])
            !!}
        </div>
        <div class="col-sm-1 p-l-0 m-t-5 m-l-5"><strong>KB</strong></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-12 text-left   p-b-5 f-w-100">Allowed Videos extensions</label>
        <div class="col-sm-12"> {!! Form::text('vid_ext',null,['tdddype'=>'allowed_img_ext','class'=>'videoext
            form-control videoextensions hide','placeholder'=>'AVI,MP4']) !!}
            <ul id="videoextensionstag" data-run-ext="video" data-ext="{{ Config('ext.videos') }}"
                data-type="allowed_vid_ext" class="m-b-0">
            </ul>
            <div data-ext="{{ Config('ext.videos') }}" class="f-s-10 p-t-5">({{ Config('ext.videos') }})</div>
        </div>
    </div>
    <div class="form-group">
        <label for="upload_size" class="control-label col-sm-12   p-b-5 text-left f-w-100">Maximum Upload Size</label>
        <div class="col-sm-3 p-r-0"> {!! Form::text('vid_ext_size',null,['class'=>'form-control','placeholder'=>'500'])
            !!}
        </div>
        <div class="col-sm-1 p-l-0 m-t-5 m-l-5"><strong>KB</strong></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-12 text-left p-b-5 f-w-100">Allowed Music extensions</label>
        <div class="col-sm-9"> {!! Form::text('music_ext',null,['class'=>'musicext form-control musicExtensions
            hide','placeholder'=>'MP4']) !!}
            <ul id="musicExtensionstag" data-run-ext="music" data-ext="{{ Config('ext.music') }}"
                data-type="allowed_music_ext" class="m-b-0">
            </ul>
            <div data-ext="{{ Config('ext.music') }}" class="f-s-10 p-t-5">({{ Config('ext.music') }})</div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-12 text-left p-b-5 f-w-100">Maximum Upload Size</label>
        <div class="col-sm-3 p-r-0"> {!!
            Form::text('music_ext_size',null,['class'=>'form-control','placeholder'=>'500']) !!}
        </div>
        <div class="col-sm-1 p-l-0 m-t-5 m-l-5"><strong>KB</strong></div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-12 text-left p-b-5 f-w-100">Allowed Docs extensions</label>
        <div class="col-sm-9 doc_ext"> {!! Form::text('doc_ext',null,['class'=>'docsext form-control docExtensions
            hide','placeholder'=>'MP4']) !!}
            <ul id="docExtensionstag" data-run-ext="docs" data-ext="{{ Config('ext.docs') }}"
                data-type="allowed_doc_ext" class="m-b-0">
            </ul>
            <div data-ext="{{ Config('ext.docs') }}" class="f-s-10 p-t-5">({{ Config('ext.docs') }})</div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-12 text-left p-b-5 f-w-100">Maximum Upload Size</label>
        <div class="col-sm-3 p-r-0"> {!! Form::text('doc_ext_size',null,['class'=>'form-control','placeholder'=>'500'])
            !!}
        </div>
        <div class="col-sm-1 p-l-0 m-t-5 m-l-5"><strong>KB</strong></div>
    </div>
</div>
