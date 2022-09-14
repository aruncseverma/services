@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
    {{ $title }}
@endsection
{{-- end title --}}

@section('main.content.title.right')
<div class="col-md-6 col-8 align-self-center text-right">
    <a href="{{ route('admin.attribute.physical.create', ['name' => $search['name']]) }}" class="btn btn-info">@lang('New')</a>
</div>
@endsection

@section('main.content')
    <div class="col-lg-12">
        <div class="row">
            @foreach ($names as $name)
                <!-- Column -->
                <div class="col-md-2 col-lg-2 col-xlg-2">
                    <a href="{{ route('admin.attributes.physical.manage', ['name' => $name]) }}" class="card card-inverse card-info box bg-info text-center @if ($search['name'] === $name) bg-danger @endif">
                            <h2 class="font-light text-white">{{ ucwords(str_replace('_', ' ', $name)) }}</h2>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="card">
            <div class="card-body">
                {{-- search --}}
                @component('Admin::common.search', ['action' => route('admin.attributes.physical.manage', ['name' => $search['name']])])
                    <input type="hidden" name="limit" value="{{ $search['limit'] }}">
                    <input type="hidden" name="name" value="{{ $search['name'] }}">

                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="content">@lang('Name')</label>
                                <input type="text" id="content" class="form-control" name="content" value="{{ $search['content'] }}">
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
                        <th>@lang('Name')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Actions')</th>
                    @endslot

                    @slot('body')
                        @forelse ($attributes as $attribute)
                            <tr>
                                <td>{{ $attribute->getDescription($search['lang_code'])->content }}</td>
                                <td>@include('Admin::common.account_status', ['isActive' => $attribute->isActive()])</td>
                                <td>
                                    @component('Admin::common.table.dropdown_actions', [
                                        'optionActions' => [
                                            'edit_' . $attribute->name => __('Update'),
                                            'update_status_' . $attribute->getKey() => $attribute->isActive() ? __('Disable') : __('Activate'),
                                        ]
                                    ])
                                        @include('Admin::common.table.actions.update', ['href' => route('admin.attribute.physical.update', ['id' => $attribute->getKey(), 'name' => $attribute->name]), 'btnId' => 'edit_' . $attribute->name])
                                        @include('Admin::common.table.actions.update_status', [
                                            'route' => 'admin.attribute.physical.update_status',
                                            'id' => $attribute->getKey(),
                                            'isActive' => $attribute->isActive(),
                                            'btnId' => 'update_status_' . $attribute->getKey(),
                                        ])
                                    @endcomponent
                                </td>
                            </tr>
                        @empty
                            @include('Admin::common.table.no_results', ['colspan' => 3])
                        @endforelse
                    @endslot
                @endcomponent

                {{ $attributes->links() }}
            </div>
        </div>
    </div>
@endsection
