@extends('Admin::settings.form')

@section('settings.form_input')
    {{-- image.min_width --}}
    @component('Admin::common.form.group', ['key' => "{$group}.min_width", 'labelClasses' => 'es-required es-numeric', 'labelId' => "{$group}_min_width"])
        @slot('label')
            @lang('Min Width') <span class="text text-danger">*</span>
        @endslot

        @slot('input')
            <input type="text" id="{{ $group }}_min_width" name="{{ $group }}[min_width]" class="form-control col-2" value="{{ config("{$group}.min_width") }}">&nbsp;px
        @endslot
    @endcomponent
    {{-- end site.min_width --}}

    {{-- image.min_height --}}
    @component('Admin::common.form.group', ['key' => "{$group}.min_height", 'labelClasses' => 'es-required es-numeric', 'labelId' => "{$group}_min_height"])
        @slot('label')
            @lang('Min Height') <span class="text text-danger">*</span>
        @endslot

        @slot('input')
            <input type="text" id="{{ $group }}_min_height" name="{{ $group }}[min_height]" class="form-control col-2" value="{{ config("{$group}.min_height") }}">&nbsp;px
        @endslot
    @endcomponent
    {{-- end site.min_height --}}

    {{-- image.max_width --}}
    @component('Admin::common.form.group', ['key' => "{$group}.max_width", 'labelClasses' => 'es-required es-numeric', 'labelId' => "{$group}_max_width"])
        @slot('label')
            @lang('Max Width') <span class="text text-danger">*</span>
        @endslot

        @slot('input')
            <input type="text" id="{{ $group }}_max_width" name="{{ $group }}[max_width]" class="form-control col-2" value="{{ config("{$group}.max_width") }}">&nbsp;px
        @endslot
    @endcomponent
    {{-- end site.max_width --}}

    {{-- image.max_height --}}
    @component('Admin::common.form.group', ['key' => "{$group}.max_height", 'labelClasses' => 'es-required es-numeric', 'labelId' => "{$group}_max_height"])
        @slot('label')
            @lang('Max Height') <span class="text text-danger">*</span>
        @endslot

        @slot('input')
            <input type="text" id="{{ $group }}_max_height" name="{{ $group }}[max_height]" class="form-control col-2" value="{{ config("{$group}.max_height") }}">&nbsp;px
        @endslot
    @endcomponent
    {{-- end site.max_height --}}
@endsection

