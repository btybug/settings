<div  class="m-10 p-15 bg-white overflow-y-hidden">

            <div class="col-sm-6 ">
            
            <div class="panel panel-default" data-sortable-id="ui-widget-1">
                  <div class="panel-heading">General Layout</div>
                  <div class="panel-body">
                                             <div class="form-group">
                                  <label class="col-sm-4 control-label f-w-100">Layout</label>
                                <label class="radio-inline">
                                  {!! Form::radio('header_layout', 'full_width',null) !!}Full Width
                                </label>
                                <label class="radio-inline">
                                  {!! Form::radio('header_layout', 'width',null) !!}Width
                                </label>
                                  </div>
                                  <div class="form-group">
                                  <label class="col-sm-4 control-label f-w-100">Header</label>
                                <label class="radio-inline">
                                  {!! Form::radio('header_style', 'sticky',null) !!} Sticky
                                </label>
                                <label class="radio-inline">
                                  {!! Form::radio('header_style', 'default',null) !!}Default
                                </label>
                                  </div>
                                  
                                            </div>
                </div>

              
            <div class="panel panel-default" data-sortable-id="ui-widget-1">
                  <div class="panel-heading">Left Side Bar</div>
                  <div class="panel-body">
                                              
                                  <div class="form-group">
                                    <label class="col-sm-4 control-label f-w-100">Width</label>
                                    <div class="col-sm-8">
                                    {!! Form::select('lnav_grid',$grids,null,['class'=>'form-control']) !!}
                                    </div>
                                  </div>
                                
                                  <div class="form-group">
                                    <label class="col-sm-4 control-label f-w-100">Default Content</label>
                                    <div class="col-sm-8">
                                     {!! Form::select('lnav_content',$contents,null,['class'=>'form-control']) !!}
                                    </div>
                                  </div>
                                
                                
                                
                                  <div class="form-group">
                                    <label class="col-sm-4 control-label f-w-100">Desktop Mobility</label>
                                 <label class="radio-inline">
                                  {!! Form::radio('lnav_dsekmobility', 'collapsable',null) !!} Collapsable
                                 </label>
                                <label class="radio-inline">
                                  {!! Form::radio('lnav_dsekmobility', 'fixed',null) !!}Fixed
                                </label>
                                  </div>
                                
                                
                                
                                  <div class="form-group">
                                    <label class="col-sm-4 control-label f-w-100">In Responsive</label>
                                 <label class="radio-inline">
                                  {!! Form::radio('lnav_responsive', 'add_to_menu',null) !!}Add to menu
                                 </label>
                                <label class="radio-inline">
                                 {!! Form::radio('lnav_responsive', 'hide',null) !!}Hide
                                </label>
                                  </div>
                               
                   
                        </div>
                </div>        
                    
               
              <div class="panel panel-default" data-sortable-id="ui-widget-1">
                  <div class="panel-heading">Right Side Bar</div>
                  <div class="panel-body">
                                        
                                  <div class="form-group">
                                    <label class="col-sm-4 control-label f-w-100">Width</label>
                                    <div class="col-sm-8">
                                      {!! Form::select('rnav_grid',$grids,null,['class'=>'form-control']) !!}
                                    </div>
                                  </div>                               
                                     
                                  <div class="form-group">
                                    <label class="col-sm-4 control-label f-w-100">Default Content</label>
                                    <div class="col-sm-8">
                                      {!! Form::select('rnav_content',$contents,null,['class'=>'form-control']) !!}
                                    </div>
                                  </div>                                
                               
                                  <div class="form-group">
                                    <label class="col-sm-4 control-label f-w-100">Desktop Mobility</label>
                                 <label class="radio-inline">
                                  {!! Form::radio('rnav_dsekmobility', 'collapsable',null) !!}Collapsable
                                 </label>
                                <label class="radio-inline">
                                  {!! Form::radio('rnav_dsekmobility', 'collapsable',null) !!}Fixed
                                </label>
                                  </div>                            
                                                                
                                  <div class="form-group">
                                    <label class="col-sm-4 control-label f-w-100">In Responsive</label>
                                 <label class="radio-inline">
                                 {!! Form::radio('rnav_responsive', 'add_to_menu',null) !!}  Add to menu
                                 </label>
                                <label class="radio-inline">
                                  {!! Form::radio('rnav_responsive', 'hide',null) !!}Hide
                                </label>
                                  </div>
                                          
                       </div>
                </div>      
                  
                         
            </div>
             
</div>          
