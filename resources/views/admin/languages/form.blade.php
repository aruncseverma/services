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

                <form class="form es es-validation" action="{{ route('admin.language.save') }}" method="POST">
                    <h4 class="card-title">@lang('Language Information')</h4>
                    <hr/>

                    {{-- hidden --}}
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $language->getKey() }}">
                    {{-- end hidden --}}

                    {{-- name --}}
                    @component('Admin::common.form.group', ['key' => 'name', 'labelClasses' => 'es-required'])
                        @slot('label')
                            @lang('Language Name') <span class="text text-danger">*</span>
                        @endslot

                        @slot('input')
                            <input type="text" class="form-control" id="name" name="name" value="{{ $language->name }}" placeholder="{{ __('Language Name') }}">
                        @endslot
                    @endcomponent
                    {{-- end name --}}

                    {{-- code --}}
                    @component('Admin::common.form.group', ['key' => 'code', 'labelClasses' => 'es-required'])
                        @slot('label')
                            @lang('Language Code') <span class="text text-danger">*</span>
                        @endslot

                        @slot('input')
                            <input id="code" @if ($language->getKey()) readonly="" @endif type="text" class="form-control" name="code" value="{{ $language->code }}" placeholder="{{ __('Language Code') }}">
                        @endslot
                    @endcomponent
                    {{-- end name --}}

                    {{-- country --}}
                    @component('Admin::common.form.group', ['key' => 'country_id'])
                        @slot('label')
                            @lang('Country')
                        @endslot

                        @slot('input')
                            @include(
                                'Admin::common.form.country',
                                [
                                    'name' => 'country_id',
                                    'value' => $language->getAttribute('country_id'),
                                    'classes' => 'form-control select2', 
                                    'attributes' => 'data-live-search="true"',
                                ]
                            )
                        @endslot
                    @endcomponent
                    {{-- end country --}}

                    {{-- is active --}}
                    @component('Admin::common.form.group', ['key' => 'is_active'])
                        @slot('label')
                            @lang('Status')
                        @endslot

                        @slot('input')
                            <div class="m-b-10">
                                <label class="custom-control custom-radio">
                                    <input id="active" name="is_active" type="radio" class="custom-control-input" @if ($language->isActive()) checked="" @endif value="1">
                                    <span class="custom-control-label">@lang('Active')</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    <input id="inactive" name="is_active" type="radio" class="custom-control-input"  @if (! $language->isActive()) checked="" @endif value="0">
                                    <span class="custom-control-label">@lang('Inactive')</span>
                                </label>
                            </div>
                        @endslot
                    @endcomponent
                    {{-- end is active --}}

                    <div class="form-actions pull-right">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                        <a href="{{ route('admin.languages.manage') }}" class="btn btn-inverse">@lang('Cancel')</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
