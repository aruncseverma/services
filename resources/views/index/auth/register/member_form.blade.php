@extends('Index::auth.register.default_form', ['action' => route('index.auth.agency.register'), 'cancelHref' => route('admin.escorts.manage')])

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

{{-- locations --}}
@include('Index::auth.register.components.locations')
{{-- end locations --}}

@endsection