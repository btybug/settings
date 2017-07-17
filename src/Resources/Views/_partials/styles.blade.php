@if(!isset($ajax))
    <div class="col-md-12 modal-data">
        <div class="col-md-4">
            @foreach($styles as $style)
                <div class="form-group">
                    <button data-key="{!! $key !!}" type="button" data-id="{!! $style->id !!}" data-action="styles"
                            class="styles form-control btn {!! ((isset($classe_id)) and $style->id==$classe_id) ? ' btn-primary ' : 'btn-info' !!} ">{!! $style->name !!}</button>
                </div>
            @endforeach
        </div>
        @endif
        <div class="col-md-8 modal-data-items">
            @foreach($items as $item)
                <div class="col-md-4 text-center height-100 m-5 item {!! (isset($item_id) and ($item_id==$item->id)) ? ' btn-primary ' : 'btn-info' !!}">
                    <input type="hidden" data-key="{!! $key !!}" data-action="styles" data-value="{!! $item->id !!}"/>
                    <span>{!! $item->name !!}</span>

                </div>

            @endforeach
        </div>
        @if(!isset($ajax))
    </div>
@endif