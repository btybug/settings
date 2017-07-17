
<div role="tabpanel" class="tab-pane" id="Miscellaneous">
  <div class="m-10">
    <div class="form-group">
      <label class="col-sm-2 control-label f-w-100 text-left">Activate Slug Optimizer</label>
      <div class="col-sm-7"> {!! Form::select('common[activate_slug_optimizer]', ['no'=>'No','yes'=>'Yes'], @$common['activate_slug_optimizer'], ['class' => 'form-control']) !!} </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label f-w-100 text-left">Stop Words List</label>
      <div class="col-sm-7"> {!! Form::textarea('common[stop_words_list]',@$common['stop_words_list'],['size' => '30x5','class'=>'form-control']) !!} </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label f-w-100 text-left">Slug part min chars</label>
      <div class="col-sm-7"> {!! Form::text('common[slug_min_chars]',@$common['slug_min_chars'],['class'=>'form-control']) !!} </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label f-w-100 text-left">Activate Insert Code</label>
      <div class="col-sm-7"> {!! Form::select('common[activate_insert_code]', ['no'=>'No','yes'=>'Yes'], @$common['activate_insert_code'], ['class' => 'form-control']) !!} </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label f-w-100 text-left">Insert code in
        <head>
      </label>
      <div class="col-sm-7"> {!! Form::textarea('common[head_code]',@$common['head_code'],['size' => '30x5','class'=>'form-control']) !!} </div>
    </div>
    <div class="form-group">
      <label class="col-sm-2 control-label f-w-100 text-left">Insert code in Footer</label>
      <div class="col-sm-7"> {!! Form::textarea('common[footer_code]',@$common['footer_code'],['size' => '30x5','class'=>'form-control']) !!} </div>
    </div>
  </div>
</div>