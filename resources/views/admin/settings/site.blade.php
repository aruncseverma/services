@extends('Admin::settings.form')

@section('settings.form_input')
    {{-- site.name --}}
    @component('Admin::common.form.group', ['key' => "{$group}.name", 'labelClasses' => 'es-required', 'labelId' => $group.'_name'])
        @slot('label')
            @lang('Site Name') <span class="text text-danger">*</span>
        @endslot

        @slot('input')
            <input type="text" id="{{ $group }}_name" name="{{ $group }}[name]" class="form-control" value="{{ config("{$group}.name") }}">
        @endslot
    @endcomponent
    {{-- end site.name --}}

    {{-- site.url --}}
    @component('Admin::common.form.group', ['key' => "{$group}.url", 'labelClasses' => 'es-required es-url', 'labelId' => $group.'_url'])
        @slot('label')
            @lang('Site URL') <span class="text text-danger">*</span>
        @endslot

        @slot('input')
            <input type="text" id="{{ $group }}_url" name="{{ $group }}[url]" class="form-control" value="{{ config("{$group}.url") }}">
        @endslot
    @endcomponent
    {{-- end site.url --}}

    {{-- site.is_maintenance --}}
    @component('Admin::common.form.group', ['key' => "{$group}.is_maintenance"])
        @slot('label')
            @lang('Maintenance Mode')
        @endslot

        @slot('input')
            <div class="m-b-10">
                <label class="custom-control custom-radio">
                    <input id="{{ $group }}.is_maintenance" name="{{ $group }}[is_maintenance]" type="radio" class="custom-control-input" @if (config("{$group}.is_maintenance")) checked="" @endif value="1">
                    <span class="custom-control-label">@lang('Yes')</span>
                </label>
                <label class="custom-control custom-radio">
                    <input id="{{ $group }}.is_maintenance" name="{{ $group }}[is_maintenance]" type="radio" class="custom-control-input"  @if (! config("{$group}.is_maintenance")) checked="" @endif value="0">
                    <span class="custom-control-label">@lang('No')</span>
                </label>
                <small class="form-control-feedback">@lang('Site will be down for maintenance and will receieved <strong>503 Service Unavailable</strong>')</small>
            </div>
        @endslot
    @endcomponent
    {{-- end site.is_maintenance --}}

    {{-- site.page_size --}}
    @component('Admin::common.form.group', ['key' => "{$group}.page_size"])
        @slot('label')
            @lang('Page Size')
        @endslot

         @slot('input')
            <input type="text" id="{{ $group }}.page_size" name="{{ $group }}[page_size]" class="form-control" value="{{ config("{$group}.page_size") }}">
        @endslot
    @endcomponent
    {{-- end site.page_size --}}
@endsection
