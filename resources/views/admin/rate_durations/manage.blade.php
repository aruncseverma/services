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
                @component('Admin::common.search', ['action' => route('admin.rate_durations.manage')])
                    <input type="hidden" name="limit" value="{{ $search['limit'] }}">

                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="name">@lang('Duration Name')</label>
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
                    </div>
                @endcomponent
                {{-- end search --}}

                {{-- notification --}}
                @include('Admin::common.notifications')
                {{-- end notification --}}

                @component('Admin::common.table')
                    @slot('head')
                        <th>@lang('Duration')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Position')</th>
                        <th>@lang('Actions')</th>
                    @endslot

                     @slot('body')
                        @forelse ($durations as $duration)
                            <tr>
                                <td>{{ $duration->getDescription($search['lang_code'])->content }}</td>
                                <td>@include('Admin::common.account_status', ['isActive' => $duration->isActive()])</td>
                                <td>{{ $duration->position }}</td>
                                <td>
                                    @component('Admin::common.table.dropdown_actions', [
                                        'optionActions' => [
                                            'edit_' . $duration->getKey() => __('Update'),
                                            'update_status_' . $duration->getKey() => $duration->isActive() ? __('Disable') : __('Activate'),
                                        ]
                                    ])
                                        @include('Admin::common.table.actions.update', ['href' => route('admin.rate_duration.update', ['id' => $duration->getKey()]), 'btnId' => 'edit_' . $duration->getKey()])
                                        @include('Admin::common.table.actions.update_status', [
                                                'route' => 'admin.rate_duration.update_status',
                                                'id' => $duration->getKey(),
                                                'isActive' => $duration->isActive(),
                                                'btnId' => 'update_status_' . $duration->getKey(),
                                            ])
                                    @endcomponent
                                </td>
                            </tr>
                        @empty
                            @include('Admin::common.table.no_results', ['colspan' => 3])
                        @endforelse
                    @endslot
                @endcomponent

                {{ $durations->links() }}
            </div>
        </div>
    </div>
@endsection
