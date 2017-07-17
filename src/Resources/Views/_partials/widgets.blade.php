@if(!isset($ajax))
    <div class="col-md-12 modal-data">
        <div class="col-md-4">
            @foreach($widgets as $w)
                <div class="form-group">
                    <button data-key="{!! $key !!}" type="button" data-id="{!! $w->slug !!}" data-action="widgets"
                            class="styles form-control btn {!! (isset($widget) and ($w->slug==$widget->slug)) ? ' btn-primary ' : 'btn-info' !!} ">{!! $w->title !!}</button>
                </div>
            @endforeach
        </div>
        @endif
        <div class="col-md-8 modal-data-items">
            @foreach($items as $item)
                <div class="col-md-4 text-center height-100 m-5 item {!! (isset($variation) and ($variation->id==$item->id)) ? ' btn-primary ' : 'btn-info' !!}">
                    <input type="hidden" data-key="{!! $key !!}" data-action="widgets" data-value="{!! $item->id !!}"/>
                    <span>{!! $item->title !!}</span>
                </div>
            @endforeach
        </div>
        @if(!isset($ajax))
    </div>
@endif