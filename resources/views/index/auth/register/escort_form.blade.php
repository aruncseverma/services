@extends('Index::auth.register.default_form', ['action' => route('index.auth.escort.register'), 'cancelHref' => route('admin.escorts.manage')])

@section('form.inputs.pre')
<h4 class="card-title">@lang('Personal Information')</h4>
<hr />

{{-- name --}}
@component('Index::common.form.group', ['key' => 'name'])
@slot('label')
@lang('Name') <span class="text text-danger">*</span>
@endslot
@slot('input')
<input type="text" id="name" class="form-control" name="name" placeholder="{{ __('Your Name') }}" value="{{ old('name') }}">
@endslot
@endcomponent
{{-- end name --}}

{{-- gender --}}
@component('Admin::common.form.group', ['key' => 'gender'])
@slot('label')
@lang('Gender') <span class="text text-danger">*</span>
@endslot

@slot('input')
<div class="m-b-10">
    <label class="custom-control custom-radio">
        <input id="gender_male" name="gender" type="radio" class="custom-control-input" value="M" @if(old('gender')=='M' ) checked="" @endif>
        <span class="custom-control-label">@lang('Male')</span>
    </label>
    <label class="custom-control custom-radio">
        <input id="gender_femaile" name="gender" type="radio" class="custom-control-input" value="F" @if(old('gender')=='F' ) checked="" @endif>
        <span class="custom-control-label">@lang('Femail')</span>
    </label>
    <label class="custom-control custom-radio">
        <input id="gender_trans" name="gender" type="radio" class="custom-control-input" value="T" @if(old('gender')=='T' ) checked="" @endif>
        <span class="custom-control-label">@lang('Trans')</span>
    </label>
</div>
@endslot
@endcomponent
{{-- end gender --}}

{{-- locations --}}
@include('Index::auth.register.components.locations')
{{-- end locations --}}

{{-- phone --}}
@component('Index::common.form.group', ['key' => 'phone'])
@slot('label')
@lang('Telephone No.')
@endslot
@slot('input')
<input type="text" id="phone" class="form-control" name="phone" placeholder="{{ __('Your Phone') }}" value="{{ old('phone') }}">
@endslot
@endcomponent
{{-- end phone --}}

@endsection