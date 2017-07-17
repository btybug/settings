
<div class="row toolbarNav p-b-0">
    <div class="row">
        <div class="col-md-6">
            <div class="form-horizontal">
                <div class="form-group p-l-20">
                    <label class=" col-xs-4 control-label text-left" >Title</label>
                    <div class="col-xs-7"> {!! Form::text('title',null,['class'=>'form-control','placeholder'=>'title']) !!} </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 text-right"> <a href="#" class="btn btn-default btn-default-gray">Discard</a> {!! Form::submit('Save',['class' => 'btn btn-danger btn-danger-red']) !!} </div>
    </div>
</div>
<div class="row toolrowsection bootbox">
    <div class="col-md-7 tooleditsection">
        <div id="panelTool">
            <div class="btn-group btn-group-justified m-t-15" role="group" aria-label="..." data-tool-tab="btnpanel">
                <div class="btn-group" role="group"> <a href="#general" aria-controls="General" role="tab" data-toggle="tab" class="btn btn-default btn-dblue active">General</a> </div>
                <div class="btn-group" role="group"> <a href="#extensions_size" aria-controls="toolcontent" role="tab" data-toggle="tab" class="btn btn-default btn-dblue">Drag&Drop</a> </div>

                <div class="btn-group" role="group"> <a href="#look_feel" aria-controls="style" role="tab" data-toggle="tab" class="btn btn-default btn-dblue">Look&Feel</a> </div>
            </div>
            <div class="tab-content p-t-20">
                <div role="tabpanel" class="tab-pane active general" id="general">
                     @include('settings::_partials.uploaders_general')
                </div>
                <div role="tabpanel" class="tab-pane " id="extensions_size">
                     @include('settings::_partials.uploaders_extensions_size')
                </div>
                
                <div role="tabpanel" class="tab-pane " id="look_feel"> 
                     @include('settings::_partials.uploaders_look_feel')
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5 p-t-15 p-r-15">  
             @include('settings::_partials.uploaders_preview')
            
    </div>
</div>
@section('CSS')
   {!! HTML::style('/public/libs/tag-it/css/jquery.tagit.css') !!}
   {!! HTML::style('public/css/tool-css.css?v=0.43') !!}
    {!! HTML::style('/public/libs/bootstrap-fileinput/css/fileinput.css') !!}
 @stop
 
 @section('JS')
{!! HTML::script('/public/libs/tag-it/js/tag-it.js') !!} 
{!! HTML::script('/public/libs/bootstrap-fileinput/js/fileinput.js') !!}
{!! HTML::script('/public/js/icon-plugin.js') !!}
{!! HTML::script('/public/js/file-uploaders.js?v=02') !!}
<script>
   
   
    $( document ).ready(function() {
	   showhideDd();
	   showHideMultiple();
	   
	   $("#uploader_type").change(function (){
		   showhideDd();
	   });
	   
	  $('#allow_chk').click(
	    function() {
		   showHideMultiple();
		}
	  )	;
	   
	});
	
	function showHideMultiple(){
        if ($("#allow_chk").is(':checked')) {
          $("#min_max").show();
    	} else {
          $("#min_max").hide();
    	}	
 	}
	
	function showhideDd(){
		$(".dd").hide();
		index = $("#uploader_type").prop('selectedIndex');	
		$("#"+index).show();
	}

   	$(function() {
     $('[data-run-ext]').each(function() {
		var	getconectwith = $(this).data('run-ext');
		var getExt = $(this).data('ext').split(',');
       $(this).tagit({
                availableTags: getExt,
                // This will make Tag-it submit a single form value, as a comma-delimited field.
                singleField: true,
				autocomplete: {delay: 0, minLength: 2},
                singleFieldNode: $('.'+getconectwith+'ext'),
				beforeTagAdded: function(event, ui) {
					if (!ui.duringInitialization) {
						var exis = getExt.indexOf(ui.tagLabel);
						if(exis<0){
							$('.tagit-new input').val('');
							//alert('PLease add allow at tag')
							return false;
						}
					}
					
				},	
				afterTagAdded:function(event, ui) {
						if (!ui.duringInitialization) {
							var value = $('.'+getconectwith+'ext').val();
							var type = $('.'+getconectwith+'ext').attr('name');
							//postAjax('/admin/media/setting/upext',{'value':value,'type':type});
						}
					},
				afterTagRemoved:function(event, ui) {
					var type = $('.'+getconectwith+'ext').attr('name');
					var value = $('.'+getconectwith+'ext').val();
					//postAjax('/admin/media/setting/upext',{'value':value,'type':type});
				}
            }); 
    });
	  
    $('[data-tool-tab="btnpanel"] a').click(function(){
		$('[data-tool-tab="btnpanel"] a').removeClass('active');
		$(this).addClass('active')
	})
    
  });
   </script> 
@stop 