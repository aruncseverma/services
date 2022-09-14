@extends('Admin::layout')

@pushAssets('styles.post')
    <style>
        /** fixed tab input width */
        .bootstrap-tagsinput {
            width: 100% !important
        }
    </style>
@endPushAssets

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

                <form class="form es es-validation" action="{{ route('admin.services.categories.save') }}" method="POST">
                    <h4 class="card-title">@lang('Category Information')</h4>
                    <hr/>

                    {{-- hidden --}}
                    <input type="hidden" name="category[ban_locations][country_ids]" value="{{ implode(',', $category->getBanLocationsByGroup('countries')) }}" id="ban_locations_country_ids">
                    <input type="hidden" name="category[ban_locations][state_ids]" value="{{ implode(',', $category->getBanLocationsByGroup('states')) }}" id="ban_locations_state_ids">
                    <input type="hidden" name="category[ban_locations][city_ids]" value="{{ implode(',', $category->getBanLocationsByGroup('cities')) }}" id="ban_locations_city_ids">
                    <input type="hidden" name="id" value="{{ $category->getKey() }}">
                    {{ csrf_field() }}
                    {{-- end hidden --}}

                    {{-- category description --}}
                    @foreach ($languages as $language)
                        @component('Admin::common.form.group', ['key' => 'descriptions.' . $language->code, 'labelClasses' => 'es-required', 'labelId' => 'descriptions_' . $language->code])
                            @slot('label')
                                @lang('Category') ({{ $language->name }}) <span class="text text-danger">*</span>
                            @endslot

                            @slot('input')
                                <input type="text" name="descriptions[{{ $language->code }}]" class="form-control @if (!$category->getKey() && $loop->first) es es-copy-text @else auto-value @endif" @if (!$category->getKey() && $loop->first) data-copy-text-target=".auto-value" @endif id="descriptions_{{ $language->code }}" placeholder="{{ __("Category in ({$language->name})")}}" value="{{ $category->getDescription($language->code)->content }}">
                            @endslot
                        @endcomponent
                    @endforeach
                    {{-- end description --}}

                    @component('Admin::common.form.group', ['key' => 'category.position', 'labelClasses' =>'es-numeric', 'labelId' => 'category_position'])
                        @slot('label')
                            @lang('Position')
                        @endslot

                        @slot('input')
                            <input type="text" id="category_position" name="category[position]" class="form-control col-1" placeholder="@lang('Pos')" value="{{ $category->position }}">
                        @endslot
                    @endcomponent

                    {{-- is active --}}
                    @component('Admin::common.form.group', ['key' => 'category.is_active'])
                        @slot('label')
                            @lang('Status')
                        @endslot

                        @slot('input')
                            <div class="m-b-10">
                                <label class="custom-control custom-radio">
                                    <input id="active" name="category[is_active]" type="radio" class="custom-control-input" @if ($category->isActive()) checked="" @endif value="1">
                                    <span class="custom-control-label">@lang('Active')</span>
                                </label>
                                <label class="custom-control custom-radio">
                                    <input id="inactive" name="category[is_active]" type="radio" class="custom-control-input"  @if (! $category->isActive()) checked="" @endif value="0">
                                    <span class="custom-control-label">@lang('Inactive')</span>
                                </label>
                            </div>
                        @endslot
                    @endcomponent
                    {{-- end is active --}}

                    <h4 class="card-title">@lang('Ban Locations')</h4>
                    <hr />
                    {{-- countries --}}
                    @component('Admin::common.form.group', ['key' => 'country_id'])
                        @slot('label')
                            @lang('Countries')
                        @endslot

                        @slot('input')
                            @include('Admin::common.form.country', [
                                'name' => 'country_id',
                                'placeholder' => true,
                                'target' => '#state_id',
                                'value' => null,
                                'classes' => 'select2 form-control',
                            ])
                        @endslot
                    @endcomponent
                    {{-- end countries --}}

                    {{-- states --}}
                    @component('Admin::common.form.group', ['key' => 'state_id'])
                        @slot('label')
                            @lang('States/Region')
                        @endslot

                        @slot('input')
                            @include('Admin::common.form.states', [
                                'name' => 'state_id',
                                'value' => null,
                                'target' => '#city_id',
                                'placeholder' => true,
                                'disable_preloaded' => true,
                                'classes' => 'select2 form-control',
                            ])
                        @endslot
                    @endcomponent
                    {{-- end ban cities --}}

                    {{-- ban cities --}}
                    @component('Admin::common.form.group', ['key' => 'city_id'])
                        @slot('label')
                            @lang('Cities')
                        @endslot

                        @slot('input')
                            @include('Admin::common.form.cities', [
                                'name' => 'city_id',
                                'value' => null,
                                'placeholder' => true,
                                'disable_preloaded' => true,
                                'classes' => 'select2 form-control',
                            ])
                        @endslot
                    @endcomponent
                    {{-- end ban cities --}}

                    @component('Admin::common.form.group', ['key' => 'tmp'])
                        @slot('label')
                            @lang('Selected Locations')
                        @endslot

                        @slot('input')
                            <input type="text" data-role="tagsinput" id="tmp" class="form-control" style="width:100% !important">
                        @endslot
                    @endcomponent

                    <div class="form-actions pull-right">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                        <a href="" class="btn btn-inverse">@lang('Cancel')</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@pushAssets('scripts.post')
<script type="text/javascript">
    // vars
    var $tmp = $('#tmp');
    $tmp.tagsinput({
        itemValue: 'id',
        itemText: function (item) {
            return item.label;
        },
    });
    var $banCountries = $('#ban_locations_country_ids');
    var $banStates = $('#ban_locations_state_ids');
    var $banCities = $('#ban_locations_city_ids');
    var pre = {!! $selectedLocations !!};

    pre.forEach(function (val) {
        $tmp.tagsinput('add', val);
    });

    /**
     * remove selected van location
     *
     * @param  [object] $target
     *
     * @return void
     */
    function removeBanLocation($target, event)
    {
        var lists = $target.val().split(',');
        var key = lists.indexOf(event.item.id.toString());
        if (key != -1) {
            lists.splice(key);
            $target.val(lists.join(','));
        }
    }

    /**
     * append selected location
     *
     * @param [object] $elm
     * @param [object] $target
     * @param [string] group
     */
    function appendBanLocation($elm, $target, group)
    {
        var $selected = $elm.find('option:selected');

        if ($selected != 'undefined') {
            // append selected location to target input
            var inputVals = $target.val();

            if (inputVals) {
                var list = inputVals.split(',');

                // do not push to stack if already clicked
                if (list.indexOf($selected.attr('value')) > -1) {
                    return;
                }

                // push to stack and join via comma
                list.push($selected.attr('value'));
                inputVals = list.join(',');
            } else {
                inputVals = $selected.attr('value');
            }

            // set target value
            $target.val(inputVals);

            // append to tagsinput
            $tmp.tagsinput(
                'add',
                {
                    id: $selected.attr('value'),
                    label: $selected.html(),
                    group: group,
                }
            );
        }
    }

    // capture change for country_id
    $('#country_id').on('change', function () {
        if (this.value) {
            appendBanLocation($(this), $banCountries, 'countries');
        }
    });

    // capture change for state_id
    $('#state_id').on('change', function () {
        if (this.value) {
            appendBanLocation($(this), $banStates, 'states');
        }
    });

    // capture change for city_id
    $('#city_id').on('change', function () {
        if (this.value) {
            appendBanLocation($(this), $banCities, 'cities');
        }
    });

    // listen on tagsinput removal
    $tmp.on('itemRemoved', function (event) {
        if (event.item.group == 'countries') {
            removeBanLocation($banCountries, event);
        } else if (event.item.group == 'states') {
            removeBanLocation($banStates, event);
        } else if (event.item.group == 'cities') {
            removeBanLocation($banCities, event);
        }
    });
</script>
@endPushAssets
