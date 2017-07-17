<table id="tpl-table" class="table table-bordered">
  <thead>
    <tr class="bg-black-darker text-white" role="row">
      <th align="left">{!! $module->title !!}'s Filters</th>
    </tr>
  </thead>
  <tbody>
    @foreach($files as $file)
    <tr role="row" >
      <td>
        <div class="col-md-9">{!! $file !!}</div>
        <div class="col-md-3">
           
           
           <a class="btn btn-default btn-warning btn-xs" href="/admin/settings/filter/edit/{!! $module->folder_name!!}_{!! $file!!}">&nbsp;<i class="fa fa-cog set-iconz"></i>&nbsp;</a>
           
        </div>
       </td>
    </tr>
    @endforeach
  </tbody>
</table>
