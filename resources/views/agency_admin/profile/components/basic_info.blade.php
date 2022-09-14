<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#basic_info">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Basic Information')</span>
        </div>
        <div class="card-header-sub">
            @lang('Please provide basic info about your agency')
        </div>
        <div class="card-body collapse show" id="basic_info">
            @if (old('notify') == 'basic_info')
                @include('AgencyAdmin::common.notifications')
            @endif

            <form action="{{ route('agency_admin.profile.update_basic_info') }}" method="POST" class="es es-validation">

                @csrf

                <div class="row">
                    <div class="col-12 form-group">
                        <label for="elm_agency_name" class="es-required">@lang('Agency Name')</label>
                        <input class="form-control" type="text" name="agency_name" value="{{ $agency->name }}" id="elm_agency_name">

                        @include('AgencyAdmin::common.form.error', ['key' => 'agency_name'])
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for="elm_continent_id" class="es-required" data-error-next-to="0">@lang('Continent')</label>
                        @include('AgencyAdmin::common.form.continent', [
                            'name' => 'continent_id',
                            'id' => 'elm_continent_id',
                            'target' => '#elm_country_id',
                            'value' => $agency->mainLocation->continent->getKey(),
                            'placeholder' => true,
                        ])

                        @include('AgencyAdmin::common.form.error', ['key' => 'continent_id'])
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for="elm_country_id"  class="es-required" data-error-next-to="0">@lang('Country')</label>
                        @include('AgencyAdmin::common.form.country', [
                            'name' => 'country_id',
                            'id' => 'elm_country_id',
                            'value' => $agency->mainLocation->country->getKey(),
                            'target' => '#elm_state_id',
                            'disable_preloaded' => true,
                            'placeholder' => true,
                        ])

                        @include('AgencyAdmin::common.form.error', ['key' => 'country_id'])
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for="elm_state_id"  class="es-required" data-error-next-to="0">@lang('States/Region')</label>
                        @include('AgencyAdmin::common.form.states', [
                            'name' => 'state_id',
                            'id' => 'elm_state_id',
                            'value' => $agency->mainLocation->state->getKey(),
                            'target' => '#elm_city_id',
                            'disable_preloaded' => true,
                            'placeholder' => true,
                        ])

                        @include('AgencyAdmin::common.form.error', ['key' => 'state_id'])
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for="elm_city_id"  class="es-required" data-error-next-to="0">@lang('City')</label>
                        @include('AgencyAdmin::common.form.cities', [
                            'name' => 'city_id',
                            'id' => 'elm_city_id',
                            'value' => $agency->mainLocation->city->getKey(),
                            'disable_preloaded' => true,
                            'placeholder' => true,
                        ])

                        @include('AgencyAdmin::common.form.error', ['key' => 'city_id'])
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save text-uppercase">@lang('Save')</button>
            </form>
        </div>
    </div>
</div>
