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

                <form class="form es es-validation" action="{{ route('admin.attribute.physical.save') }}" method="POST">
                    <h4 class="card-title">@lang('Attribute Information')</h4>
                    <hr/>

                    {{-- hidden --}}
                    {{ csrf_field() }}
                    <input type="hidden" name="name" value="{{ $name }}">
                    <input type="hidden" name="id" value="{{ $attribute->getKey() }}">
                    {{-- end hidden --}}

                    {{-- attribute description --}}
                    @foreach ($languages as $language)
                        @component('Admin::common.form.group', ['key' => 'descriptions.' . $language->code, 'labelClasses' => 'es-required', 'labelId' => 'descriptions_' . $language->code])
                            @slot('label')
                                @lang('Attribute Name') ({{ $language->name }}) <span class="text text-danger">*</span>
                            @endslot

                            @slot('input')
                                <input type="text" name="descriptions[{{ $language->code }}]" class="form-control @if (!$attribute->getKey() && $loop->first) es es-copy-text @else auto-value @endif" @if (!$attribute->getKey() && $loop->first) data-copy-text-target=".auto-value" @endif id="descriptions_{{ $language->code }}" placeholder="{{ __("Attribute Name in ({$language->name})")}}" value="{{ $attribute->getDescription($language->code)->content }}">
                            @endslot
                        @endcomponent
                    @endforeach
                    {{-- end description --}}

                    {{-- is active --}}
                    @component('Admin::common.form.group', ['key' => 'attribute.is_active'])
                        @slot('label')
                            @lang('Status')
                        @endslot

                        @slot('input')
                            <div class="m-b-10">
                                <label class="custom-control custom-radio">
                                    <input id="active" name="attribute[is_active]" type="radio" class="custom-control-input" @if ($attribute->isActive()) checked="" @endif value="1">
                                    <span class="custom-control-label">@lang('Active')</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    <input id="inactive" name="attribute[is_active]" type="radio" class="custom-control-input"  @if (! $attribute->isActive()) checked="" @endif value="0">
                                    <span class="custom-control-label">@lang('Inactive')</span>
                                </label>
                            </div>
                        @endslot
                    @endcomponent
                    {{-- end is active --}}

                    <div class="form-actions pull-right">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                        <a href="{{ route('admin.attributes.physical.manage', ['name' => $name]) }}" class="btn btn-inverse">@lang('Cancel')</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
