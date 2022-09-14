@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
    {{ $title }}
@endsection
{{-- end title --}}

@section('main.content')
    <div class="col-lg-12">
        {{-- body.pre --}}
        @yield('manage.content.pre')
        {{-- end body.pre --}}

        <div class="card">
            <div class="card-body">
                {{-- search --}}
                @component('Admin::common.search', ['action' => $searchAction])
                    <input type="hidden" name="limit" value="{{ $search['limit'] }}">

                    <div class="row p-t-20">
                        @section('search.form')
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="name">@lang('Name')</label>
                                    <input type="text" id="name" class="form-control" name="name" value="{{ $search['name'] }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="is_active">@lang('Account Status')</label>
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
                                    <label class="control-label" for="email">@lang('Email')</label>
                                    <input type="text" id="email" class="form-control" name="email" value="{{ $search['email'] ?? '' }}">
                                </div>
                            </div>
                        @show
                    </div>
                @endcomponent
                {{-- end search --}}

                {{-- notification --}}
                @include('Admin::common.notifications')
                {{-- end notification --}}

                {{-- content --}}
                @yield('manage.table.content')
                {{-- end content --}}
            </div>
        </div>
    </div>
@endsection
