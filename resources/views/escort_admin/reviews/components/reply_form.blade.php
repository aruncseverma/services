<form action="{{ route('escort_admin.reviews.reply') }}" method="POST" class="es es-validation">
    @csrf
    <input type="hidden" name="id" value="{{ $review->getKey() ?? '' }}">
    <label for="reply_content_{{ $review->getKey() }}" class="es-required es-image" style="display:none;">Reply</label>
    <textarea class="form-control" rows="3" placeholder="" name="content" maxlength="255" id="reply_content_{{ $review->getKey() }}"></textarea>
    <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save">@lang('SUBMIT')</button>
    <button type="button" class="btn btn-outline-secondary waves-effect waves-light button-save-two m-r-10" data-toggle="collapse" data-target="#reply_form_{{ $review->id }}">@lang('CANCEL')</button>
</form>

