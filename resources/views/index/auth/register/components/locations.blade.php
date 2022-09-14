{{-- continent --}}
@component('Index::common.form.group', ['key' => 'continent'])
@slot('label')
@lang('Continent') <span class="text text-danger">*</span>
@endslot
@slot('input')
@include(
'Index::common.form.continent',
[
'name' => 'continent',
'id' => 'location_continent',
'value' => old('continent'),
'target' => '#location_country',
'placeholder' => true,
]
)
@endslot
@endcomponent
{{-- end continent --}}

{{-- country --}}
@component('Index::common.form.group', ['key' => 'country'])
@slot('label')
@lang('Country') <span class="text text-danger">*</span>
@endslot
@slot('input')
@include(
'Index::common.form.country',
[
'name' => 'country',
'id' => 'location_country',
'value' => old('country'),
'target' => '#location_state',
'disable_preloaded' => true,
'placeholder' => true,
]
)
@endslot
@endcomponent
{{-- end country --}}

{{-- state --}}
@component('Index::common.form.group', ['key' => 'state'])
@slot('label')
@lang('State') <span class="text text-danger">*</span>
@endslot
@slot('input')
@include(
'Index::common.form.states',
[
'name' => 'state',
'id' => 'location_state',
'value' => old('state'),
'target' => '#location_city',
'disable_preloaded' => true,
'placeholder' => true,
]
)
@endslot
@endcomponent
{{-- end state --}}

{{-- city --}}
@component('Index::common.form.group', ['key' => 'city'])
@slot('label')
@lang('City') <span class="text text-danger">*</span>
@endslot
@slot('input')
@include(
'Index::common.form.cities',
[
'name' => 'city',
'id' => 'location_city',
'value' => old('city'),
'disable_preloaded' => true,
'placeholder' => true,
]
)
@endslot
@endcomponent
{{-- end city --}}
