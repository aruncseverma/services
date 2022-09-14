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
                {{-- search --}}
                @component('Admin::common.search', ['action' => route('admin.languages.manage')])
                    <input type="hidden" name="limit" value="{{ $search['limit'] }}">

                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="name">@lang('Language Name')</label>
                                <input type="text" id="name" class="form-control" name="name" value="{{ $search['name'] }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="is_active">@lang('Status')</label>
                                <div class="m-b-10">
                                    <label class="custom-control custom-radio">
                                        <input id="active" name="is_active" type="radio" class="custom-control-input" @if ($search['is_active'] == '1') checked="" @endif value="1">
                                        <span class="custom-control-label">@lang('Active')</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input id="inactive" name="is_active" type="radio" class="custom-control-input" @if ($search['is_active'] == '0') checked="" @endif value="0">
                                        <span class="custom-control-label">@lang('Inactive')</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input id="all" name="is_active" type="radio" class="custom-control-input" @if ($search['is_active'] == '*') checked="" @endif value="*">
                                        <span class="custom-control-label">@lang('All')</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="code">@lang('Language Code')</label>
                                <input type="text" id="code" class="form-control" name="code" value="{{ $search['code'] }}">
                            </div>
                        </div>
                    </div>
                @endcomponent
                {{-- end search --}}

                {{-- notification --}}
                @include('Admin::common.notifications')
                {{-- end notification --}}

                @component('Admin::common.table')
                    @slot('head')
                        <th>@lang('Name')</th>
                        <th>@lang('Code')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Actions')</th>
                    @endslot

                    @slot('body')
                        @forelse ($languages as $language)
                            <tr>
                                <td>{{ $language->name }}</td>
                                <td>{{ $language->code }}</td>
                                <td>@include('Admin::common.account_status', ['isActive' => $language->isActive()])</td>
                                <td>
                                    @component('Admin::common.table.dropdown_actions', [
                                        'optionActions' => [
                                            'edit_' . $language->getKey() => __('Update'),
                                            'update_status_' . $language->getKey() => $language->isActive() ? __('Disable') : __('Activate'),
                                        ]
                                    ])
                                        @include('Admin::common.table.actions.update', ['href' => route('admin.language.update', ['id' => $language->getKey()]), 'btnId' => 'edit_' . $language->getKey()])
                                        @include('Admin::common.table.actions.update_status', [
                                                'route' => 'admin.language.update_status',
                                                'id' => $language->getKey(),
                                                'isActive' => $language->isActive(),
                                                'btnId' => 'update_status_' . $language->getKey(),
                                            ])
                                    @endcomponent
                                </td>
                            </tr>
                        @empty
                            @include('Admin::common.table.no_results', ['colspan' => 4])
                        @endforelse
                    @endslot
                @endcomponent

                {{ $languages->links() }}
            </div>
        </div>
    </div>
@endsection

