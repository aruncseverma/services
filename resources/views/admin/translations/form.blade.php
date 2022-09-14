@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
{{ $title }}
@endsection
{{-- end title --}}

@section('main.content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            {{-- notification --}}
            @include('Admin::common.notifications')
            {{-- end notification --}}

            <form class="form es es-validation" action="{{ route('admin.translation.save') }}" method="POST">
                <h4 class="card-title">@lang('Translation Information')</h4>
                <hr />

                {{-- hidden --}}
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $translation->getKey() }}">
                {{-- end hidden --}}

                @component('Admin::common.form.group', ['key' => 'translation.group', 'labelClasses' => 'es-required', 'labelId' => 'translation_group'])
                @slot('label')
                @lang('Group') <span class="text text-danger">*</span>
                @endslot
                @slot('input')
                <input type="text" id="translation_group" name="translation[group]" class="form-control" placeholder="@lang('Group')" value="{{ $translation->group ?? '' }}" autocomplete="off" spellcheck="false">
                @endslot
                @endcomponent

                @component('Admin::common.form.group', ['key' => 'translation.key', 'labelClasses' => 'es-required', 'labelId' => 'translation_key'])
                @slot('label')
                @lang('Key') <span class="text text-danger">*</span>
                @endslot
                @slot('input')
                <input type="text" id="translation_key" name="translation[key]" class="form-control" placeholder="@lang('Key')" value="{{ $translation->key ?? '' }}">
                @endslot
                @endcomponent

                <h4 class="card-title">@lang('Text Information')</h4>
                <hr />
                {{-- text description --}}
                @foreach ($languages as $language)
                @component('Admin::common.form.group', ['key' => 'translation.text.' . $language->code, 'labelClasses' => 'es-required', 'labelId' => 'text_' . $language->code])
                @slot('label')
                @lang('Text') ({{ $language->name }}) <span class="text text-danger">*</span>
                @endslot

                @slot('input')
                <textarea name="translation[text][{{ $language->code }}]" class="form-control @if ($loop->first) text-paste @else auto-value @endif" @if ($loop->first) data-copy-text-target=".auto-value" @endif id="text_{{ $language->code }}" placeholder="{{ __("Text in ({$language->name})") }}">{{ $translation->text[$language->code] ?? '' }}</textarea>
                @endslot
                @endcomponent
                @endforeach
                {{-- end text description --}}

                <div class="form-actions pull-right">
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                    <a href="{{ route('admin.translations.manage') }}" class="btn btn-inverse">@lang('Cancel')</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@pushAssets('scripts.post')
<!-- Autocomplete -->
<script src="{{ asset('assets/theme/admin/default/plugins/bootstrap-autocomplete/bootstrap-autocomplete.min.js') }}"></script>

<script>
    $(function() {
        fnAjax({
            url: '{{ route("admin.translations.get_groups") }}',
            method: 'GET',
            success: function(data) {
                var $group = $('#translation_group');
                $group.autoComplete({
                    resolver: 'custom',
                    events: {
                        search: function(qry, callback) {
                            var res = [];
                            if (qry != '') {
                                for (var i in data) {
                                    if (data[i].indexOf(qry) !== -1) {
                                        res.push(data[i]);
                                    }
                                }
                            } else {
                                res = data;
                            }

                            callback(res);
                        }
                    },
                    minLength: 0,

                });
                $group.focus(function() {
                    $group.autoComplete('show');
                })
            }
        });

        
        var $id = $('[name="id"]');
        if ($id.val() == '') {
            var $textPasteElems = $('.text-paste');
            if ($textPasteElems.length) {
                $textPasteElems.each(function(index, elm) {
                    fnCopyText($(this));
                });
            }
        }
    });
</script>
@endPushAssets