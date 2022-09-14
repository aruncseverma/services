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

                <form class="form es es-validation" action="{{ route('admin.rate_duration.save') }}" method="POST">
                    <h4 class="card-title">@lang('Rate Duration Information')</h4>
                    <hr/>

                    {{-- hidden --}}
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{ $duration->getKey() }}">
                    {{-- end hidden --}}

                    {{-- duration description --}}
                    @foreach ($languages as $language)
                        @component('Admin::common.form.group', ['key' => 'descriptions.' . $language->code, 'labelClasses' => 'es-required', 'labelId' => 'descriptions_' . $language->code])
                            @slot('label')
                                @lang('Duration') ({{ $language->name }}) <span class="text text-danger">*</span>
                            @endslot

                            @slot('input')
                                <input type="text" name="descriptions[{{ $language->code }}]" class="form-control @if (!$duration->getKey() && $loop->first) es es-copy-text @else auto-value @endif" @if (!$duration->getKey() && $loop->first) data-copy-text-target=".auto-value" @endif id="descriptions_{{ $language->code }}" placeholder="{{ __("Duration in ({$language->name})")}}" value="{{ $duration->getDescription($language->code)->content }}">
                            @endslot
                        @endcomponent
                    @endforeach
                    {{-- end description --}}

                    @component('Admin::common.form.group', ['key' => 'duration.position', 'labelClasses' => 'es-required es-numeric', 'labelId' => 'position'])
                        @slot('label')
                            @lang('Position')
                        @endslot

                        @slot('input')
                            <input type="text" id="position" name="duration[position]" class="form-control col-1" placeholder="@lang('Pos')" value="{{ $duration->position }}">
                        @endslot
                    @endcomponent

                    {{-- is active --}}
                    @component('Admin::common.form.group', ['key' => 'duration.is_active'])
                        @slot('label')
                            @lang('Status')
                        @endslot

                        @slot('input')
                            <div class="m-b-10">
                                <label class="custom-control custom-radio">
                                    <input id="active" name="duration[is_active]" type="radio" class="custom-control-input" @if ($duration->isActive()) checked="" @endif value="1">
                                    <span class="custom-control-label">@lang('Active')</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    <input id="inactive" name="duration[is_active]" type="radio" class="custom-control-input"  @if (! $duration->isActive()) checked="" @endif value="0">
                                    <span class="custom-control-label">@lang('Inactive')</span>
                                </label>
                            </div>
                        @endslot
                    @endcomponent
                    {{-- end is active --}}

                    <div class="form-actions pull-right">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                        <a href="{{ route('admin.rate_durations.manage') }}" class="btn btn-inverse">@lang('Cancel')</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
