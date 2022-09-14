@if ($note)
    <div class="form-group row">
        <div class="col-md-12">
            @lang('Author'): {{ $note->user->name }}
            <textarea class="form-control" disabled="" rows="5">{{ $note->content }}</textarea>
            <span class="form-control-feedback">@lang('Created'): {{ $note->getAttribute($note->getCreatedAtColumn()) }}</span>
            <br/>
            @if ($edited = $note->getAttribute($note->getUpdatedAtColumn()))
                <span class="form-control-feedback">@lang('Edited'): {{ $edited }}</span>
            @endif
        </div>
    </div>
@else
    <div class="form-group text-center">
        @lang('No note found.')
    </div>
@endforelse
