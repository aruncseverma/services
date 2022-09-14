<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#basic_info">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Basic Information')</span>
        </div>
        <div class="card-header-sub">
            @lang('Please provide basic info about your member')
        </div>
        <div class="card-body collapse show" id="basic_info">
            @if (old('notify') == 'basic_info')
                @include('MemberAdmin::common.notifications')
            @endif

            <form action="{{ route('member_admin.profile.update_basic_info') }}" method="POST" class="es es-validation">

                @csrf

                <div class="row">
                    <div class="col-12 form-group">
                        <label for="elm_member_name" class="es-required">@lang('Member Name')</label>
                        <input class="form-control" type="text" name="member_name" value="{{ $member->name }}" id="elm_member_name">

                        @include('MemberAdmin::common.form.error', ['key' => 'member_name'])
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for="elm_continent_id" class="es-required" data-error-next-to="0">@lang('Continent')</label>
                        @include('MemberAdmin::common.form.continent', [
                            'name' => 'continent_id',
                            'id' => 'elm_continent_id',
                            'target' => '#elm_country_id',
                            'value' => $member->mainLocation->continent->getKey(),
                            'placeholder' => true,
                        ])

                        @include('MemberAdmin::common.form.error', ['key' => 'continent_id'])
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for="elm_country_id" class="es-required" data-error-next-to="0">@lang('Country')</label>
                        @include('MemberAdmin::common.form.country', [
                            'name' => 'country_id',
                            'id' => 'elm_country_id',
                            'value' => $member->mainLocation->country->getKey(),
                            'target' => '#elm_state_id',
                            'disable_preloaded' => true,
                            'placeholder' => true,
                        ])

                        @include('MemberAdmin::common.form.error', ['key' => 'country_id'])
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for="elm_state_id" class="es-required" data-error-next-to="0">@lang('States/Region')</label>
                        @include('MemberAdmin::common.form.states', [
                            'name' => 'state_id',
                            'id' => 'elm_state_id',
                            'value' => $member->mainLocation->state->getKey(),
                            'target' => '#elm_city_id',
                            'disable_preloaded' => true,
                            'placeholder' => true,
                        ])

                        @include('MemberAdmin::common.form.error', ['key' => 'state_id'])
                    </div>
                    <div class="col-sm-3 form-group">
                        <label for="elm_city_id" class="es-required" data-error-next-to="0">@lang('City')</label>
                        @include('MemberAdmin::common.form.cities', [
                            'name' => 'city_id',
                            'id' => 'elm_city_id',
                            'value' => $member->mainLocation->city->getKey(),
                            'disable_preloaded' => true,
                            'placeholder' => true,
                        ])

                        @include('MemberAdmin::common.form.error', ['key' => 'city_id'])
                    </div>
                </div>

                <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save text-uppercase">@lang('Save')</button>
            </form>
        </div>
    </div>
</div>
