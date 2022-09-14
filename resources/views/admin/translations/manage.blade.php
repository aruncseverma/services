@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
{{ $title }}
@endsection
{{-- end title --}}

@section('main.content.title.right')
<div class="col-md-6 col-8 align-self-center text-right">
    <a href="{{ route('admin.translation.create') }}" class="btn btn-info">@lang('New')</a>

    <div class="dropdown" style="display:inline-block;">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @lang('Actions')
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a href="{{ route('admin.translation.m_create') }}" class="dropdown-item">@lang('Bulk translation addition')</a>
            @if($translations->count())
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item es es-submit es-confirm es-need-selected-items" data-need-selected-items-selector=".trans-ids" data-form-id="form_translations" data-form-action="{{ route('admin.translations.m_delete') }}">@lang('Delete selected')</a>
            @endif
        </div>
    </div>

    @if($translations->count())
    <a href="#" class="btn btn-success es es-submit" data-form-id="form_translations">@lang('Save')</a>
    @endif
</div>
@endsection

@section('main.content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            {{-- search --}}
            @component('Admin::common.search', ['action' => route('admin.translations.manage')])
            <input type="hidden" name="limit" value="{{ $search['limit'] }}">

            <div class="row p-t-20">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="translation_group">@lang('Group')</label>
                        <input type="text" id="translation_group" class="form-control" name="group" value="{{ $search['group'] }}" autocomplete="off" spellcheck="false">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="key">@lang('Key')</label>
                        <input type="text" id="key" class="form-control" name="key" value="{{ $search['key'] }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="text">@lang('Text')</label>
                        <input type="text" id="text" class="form-control" name="text" value="{{ $search['text'] }}">
                    </div>
                </div>
            </div>
            @endcomponent
            {{-- end search --}}

            {{-- notification --}}
            @include('Admin::common.notifications')
            {{-- end notification --}}

            <form id="form_translations" method="POST" action="{{ route('admin.translations.m_update') }}">
                @csrf
                @component('Admin::common.table')
                @slot('head')
                <th>
                    <div class="checkbox" style="height: 20px;">
                        <input type="checkbox" id="checkbox0" value="check" class="es es-check-items" data-check-items-selector=".trans-ids">
                        <label for="checkbox0"></label>
                    </div>
                </th>
                <th>@lang('Group')</th>
                <th>@lang('Key')</th>
                <th>@lang('Text')</th>
                <th>@lang('Date')</th>
                <th>@lang('Actions')</th>
                @endslot

                @slot('body')
                @forelse ($translations as $trans)
                <tr>
                    <td style="width:40px">
                        <div class="checkbox">
                            <input type="checkbox" name="ids[]" class="trans-ids" id="checkbox{{ $trans->getKey() }}" value="{{ $trans->getKey() }}">
                            <label for="checkbox{{ $trans->getKey() }}"></label>
                        </div>
                    </td>
                    <td>{{ $trans->group }}</td>
                    <td>{{ $trans->key }}</td>
                    <td>
                        @foreach($languages as $lang)
                        <label for="{{ $lang->code }}_{{ $trans->getKey() }}" style="width: 100px;font-size:12px;display:block;">{{ $lang->name }}</label>
                        <textarea class="form-control" style="resize: vertical;" rows="1" id=" {{ $lang->code }}_{{ $trans->getKey() }}" name="text[{{ $trans->getKey() }}][{{ $lang->code }}]">{{ $trans->text[$lang->code] ?? '' }}</textarea>
                        <br />
                        @endforeach
                    </td>
                    <td>{{ $trans->created_at }}</td>
                    <td>
                        @component('Admin::common.table.dropdown_actions', [
                        'optionActions' => [
                        'edit_' . $trans->getKey() => __('Update'),
                        'delete_' . $trans->getKey() => __('Delete'),
                        ]
                        ])
                        @include('Admin::common.table.actions.update', ['href' => route('admin.translation.update', ['id' => $trans->getKey()]), 'btnId' => 'edit_' . $trans->getKey()])
                        @include('Admin::common.table.actions.delete', ['to' => route('admin.translation.delete'), 'id' => $trans->getKey(), 'btnId' => 'delete_' . $trans->getKey()])
                        @endcomponent
                    </td>
                </tr>
                @empty
                @include('Admin::common.table.no_results', ['colspan' => 6])
                @endforelse
                @endslot
                @endcomponent
            </form>
            {{ $translations->links() }}
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
    });
</script>
@endPushAssets