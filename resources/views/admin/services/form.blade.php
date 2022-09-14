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

            <form class="form es es-validation" action="{{ route('admin.service.save') }}" method="POST">
                <h4 class="card-title">@lang('Service Information')</h4>
                <hr />

                {{-- hidden --}}
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $service->getKey() }}">
                {{-- end hidden --}}

                {{-- service description --}}
                @foreach ($languages as $language)
                @component('Admin::common.form.group', ['key' => 'descriptions.' . $language->code, 'labelClasses' => 'es-required', 'labelId' => 'descriptions_' . $language->code])
                @slot('label')
                @lang('Service') ({{ $language->name }}) <span class="text text-danger">*</span>
                @endslot

                @slot('input')
                <input type="text" name="descriptions[{{ $language->code }}]" class="form-control @if (!$service->getKey() && $loop->first) es es-copy-text @else auto-value @endif" @if (!$service->getKey() && $loop->first) data-copy-text-target=".auto-value" @endif id="descriptions_{{ $language->code }}" placeholder="{{ __("Service in ({$language->name})")}}" value="{{ $service->getDescription($language->code)->content }}">
                @endslot
                @endcomponent
                @endforeach
                {{-- end description --}}

                {{-- category --}}
                @component('Admin::common.form.group', ['key' => 'service.service_category_id'])
                @slot('label')
                @lang('Category') <span class="text text-danger">*</span>
                @endslot

                @slot('input')
                <select name="service[service_category_id]" class="form-control">
                    @foreach ($categories as $category)
                    <option value="{{ $category->getKey() }}" @if ($category->getKey() == $service->getAttribute('service_category_id')) selected="" @endif>{{ $category->getDescription(app()->getLocale())->content }}</option>
                    @endforeach
                </select>
                @endslot
                @endcomponent
                {{-- end category --}}

                {{-- is active --}}
                @component('Admin::common.form.group', ['key' => 'service.is_active'])
                @slot('label')
                @lang('Status')
                @endslot

                @slot('input')
                <div class="m-b-10">
                    <label class="custom-control custom-radio">
                        <input id="active" name="service[is_active]" type="radio" class="custom-control-input" @if ($service->isActive()) checked="" @endif value="1">
                        <span class="custom-control-label">@lang('Active')</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input id="inactive" name="service[is_active]" type="radio" class="custom-control-input" @if (! $service->isActive()) checked="" @endif value="0">
                        <span class="custom-control-label">@lang('Inactive')</span>
                    </label>
                </div>
                @endslot
                @endcomponent
                {{-- end is active --}}

                <div class="form-actions pull-right">
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                    <a href="{{ route('admin.services.manage') }}" class="btn btn-inverse">@lang('Cancel')</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection