<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#location">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Location')</span>
        </div>
        <div class="card-header-sub">
            @lang('Remaining number of locations you can add: '){{$remainingNumberOfAdditionalLocations ?? '0' }}
        </div>
        <div class="card-body collapse show" id="location">
            <form action="{{ route('escort_admin.profile.main_location') }}" method="POST" class="es es-validation">
            @csrf
                <div class="row">
                    <div class="col-12">
                        <h4>@lang('Main Location')</h4>
                    </div>
                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-3 form-group">
                                <label for="main_location_continent" class="es-required" data-error-next-to="0">@lang('Continent')</label>
                                @include(
                                'EscortAdmin::common.form.continent',
                                    [
                                        'name' => 'main_location[continent]',
                                        'id' => 'main_location_continent',
                                        'value' => $user->mainLocation->continent_id ?? old('main_location.continent'),
                                        'target' => '#main_location_country',
                                        'placeholder' => true,
                                    ]
                                )
                                @include('Admin::common.form.error', ['key' => 'main_location.continent'])
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="main_location_country" class="es-required" data-error-next-to="0">@lang('Country')</label>
                                @include(
                                'EscortAdmin::common.form.country',
                                    [
                                        'name' => 'main_location[country]',
                                        'id' => 'main_location_country',
                                        'value' => $user->mainLocation->country_id ?? old('main_location.country_id'),
                                        'target' => '#main_location_state',
                                        'disable_preloaded' => true,
                                        'placeholder' => true,
                                    ]
                                )
                                @include('Admin::common.form.error', ['key' => 'main_location.country'])
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="main_location_state" class="es-required" data-error-next-to="0">@lang('Region')</label>
                                @include(
                                'EscortAdmin::common.form.states',
                                    [
                                        'name' => 'main_location[state]',
                                        'id' => 'main_location_state',
                                        'value' => $user->mainLocation->state_id ?? old('main_location_state.state_id'),
                                        'target' => '#main_location_city',
                                        'disable_preloaded' => true,
                                        'placeholder' => true,
                                    ]
                                )
                                @include('Admin::common.form.error', ['key' => 'main_location.state'])
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="main_location_city" class="es-required" data-error-next-to="0">@lang('City')</label>
                                 @include(
                                'EscortAdmin::common.form.states',
                                    [
                                        'name' => 'main_location[city]',
                                        'id' => 'main_location_city',
                                        'value' => $user->mainLocation->city_id ?? old('main_location_state.city_id'),
                                        'disable_preloaded' => true,
                                        'placeholder' => true,
                                    ]
                                )
                                @include('Admin::common.form.error', ['key' => 'main_location.city'])
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 form-group">
                        <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save" style="width: 100%">@lang('SAVE')</button>
                    </div>
                </div>
            </form>

            <form action="{{ route('escort_admin.profile.additional_location') }}" method="POST" class="es es-validation">
            @csrf
                <div class="row">
                    <div class="col-12">
                        <h4>@lang('Additional Location')</h4>
                    </div>

                    @forelse ($user->additionalLocation as $location)
                        <div class="col-sm-10">
                            <div class="row">
                                <div class="col-sm-3 form-group m-b-5">
                                    <input class="form-control" type="text" value="{{ $location->continent->name ?? '' }}" id="" readonly>
                                </div>
                                <div class="col-sm-3 form-group m-b-5">
                                    <input class="form-control" type="text" value="{{ $location->country->name  ?? '' }}" id="" readonly>
                                </div>
                                <div class="col-sm-3 form-group m-b-5">
                                    <input class="form-control" type="text" value="{{ $location->state->name  ?? '' }}" id="" readonly>
                                </div>
                                <div class="col-sm-3 form-group m-b-5">
                                    <input class="form-control" type="text" value="{{ $location->city->name  ?? '' }}" id="" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 form-group m-b-5">
                            <a href="{{ route('escort_admin.profile.delete_location',['id'=> $location->id])}}" class="btn btn-outline-secondary waves-effect waves-light button-save es es-confirm" style="width: 100%">-</a>
                        </div>
                    @empty
                    @endforelse

                    <div class="col-sm-10">
                        <div class="row">
                            <div class="col-sm-3 form-group">
                                <label for="additional_location_continent" class="es-required" data-error-next-to="0">@lang('Continent')</label>
                                @include(
                                'EscortAdmin::common.form.continent',
                                    [
                                        'name' => 'additional_location[continent]',
                                        'id' => 'additional_location_continent',
                                        'value' => old('additional_location.continent') ?? '',
                                        'attributes' => 'data-style=form-drop',
                                        'target' => '#additional_location_country',
                                        'placeholder' => true,
                                    ]
                                )
                                @include('Admin::common.form.error', ['key' => 'additional_location.continent'])
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="additional_location_country" class="es-required" data-error-next-to="0">@lang('Country')</label>
                                @include(
                                'EscortAdmin::common.form.country',
                                    [
                                        'name' => 'additional_location[country]',
                                        'id' => 'additional_location_country',
                                        'value' => old('additional_location.country') ?? '',
                                        'attributes' => 'data-style=form-drop',
                                        'target' => '#additional_location_state',
                                        'disable_preloaded' => true,
                                        'placeholder' => true,
                                    ]
                                )
                                @include('Admin::common.form.error', ['key' => 'additional_location.country'])
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="additional_location_state" class="es-required" data-error-next-to="0">@lang('Region')</label>
                                @include(
                                'EscortAdmin::common.form.states',
                                    [
                                        'name' => 'additional_location[state]',
                                        'id' => 'additional_location_state',
                                        'value' => old('additional_location.state') ?? '',
                                        'attributes' => 'data-style=form-drop',
                                        'target' => '#additional_location_city',
                                        'disable_preloaded' => true,
                                        'placeholder' => true,
                                    ]
                                )
                                @include('Admin::common.form.error', ['key' => 'additional_location.state'])
                            </div>
                            <div class="col-sm-3 form-group">
                                <label for="additional_location_city" class="es-required" data-error-next-to="0">@lang('City')</label>
                                @include(
                                'EscortAdmin::common.form.states',
                                    [
                                        'name' => 'additional_location[city]',
                                        'id' => 'additional_location_city',
                                        'value' => old('additional_location_state.city_id') ?? '',
                                        'attributes' => 'data-style=form-drop',
                                        'disable_preloaded' => true,
                                        'placeholder' => true,
                                    ]
                                )
                                @include('Admin::common.form.error', ['key' => 'additional_location.city'])
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 form-group">
                        <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save" style="width: 100%">+</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
