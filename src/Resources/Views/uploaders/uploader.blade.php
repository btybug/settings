<input id="input-2" name="file" 
		type="file" 
        class="file" 
        data-show-upload="{!! @$settings['show_upload'] !!}" 
        data-show-preview="{!! @$settings['show_preview'] !!}"
        data-show-caption = "{!! @$settings['show_caption'] !!}"
        data-show-remove = "{!! @$settings['show_remove'] !!}"
        data-show_cancel = "{!! @$settings['show_Cancel'] !!}"
        >
@push('javascript') 
{!! HTML::script('/public/libs/bootstrap-fileinput/js/fileinput.js') !!}
<script>
$("#input-2").fileinput({
    uploadUrl: "/admin/media/upload", // server upload action
    uploadAsync: true,
    maxFileCount: 5,
	uploadExtraData: {
        img_keywords: "happy, places",
    }
});
</script>
@endpush

@push('css')
{!! HTML::style('/public/libs/bootstrap-fileinput/css/fileinput.css') !!}
@endpush 