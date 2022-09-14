<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#addtour">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Add Tour')</span>
        </div>
        <div class="card-header-sub">
            @lang('You can add tour plan here')
        </div>
        <div class="card-body collapse show" id="addtour">
            <form action="{{ route('escort_admin.tour_plans.add') }}" method="POST" id="add_tour_form" class="es es-validation">
                @csrf
                <div class="row">
                    <div class="col-lg-3 col-sm-6 form-group">
                        <label for="continent_id" class="es-required" data-error-next-to="0">@lang('Continent')</label>
                        @include(
                        'EscortAdmin::common.form.continent',
                        [
                        'name' => 'continent_id',
                        'id' => 'continent_id',
                        'value' => old('continent_id', ''),
                        'target' => '#country_id',
                        'placeholder' => true
                        ]
                        )
                        @include('Admin::common.form.error', ['key' => 'continent_id'])
                    </div>
                    <div class="col-lg-3 col-sm-6 form-group">
                        <label for="country_id" class="es-required" data-error-next-to="0">@lang('Country')</label>
                        @include(
                        'EscortAdmin::common.form.country',
                        [
                        'name' => 'country_id',
                        'id' => 'country_id',
                        'value' => old('country_id', ''),
                        'target' => '#state_id',
                        'placeholder' => true,
                        'disable_preloaded' => true
                        ]
                        )
                        @include('Admin::common.form.error', ['key' => 'country_id'])
                    </div>
                    <div class="col-lg-3 col-sm-6 form-group">
                        <label for="state_id" class="es-required" data-error-next-to="0">@lang('State')</label>
                        @include(
                        'EscortAdmin::common.form.states',
                            [
                                'name' => 'state_id',
                                'id' => 'state_id',
                                'value' => old('state_id', ''),
                                'target' => '#city_id',
                                'placeholder' => true,
                                'disable_preloaded' => true
                            ]
                        )
                        @include('Admin::common.form.error', ['key' => 'state_id'])
                    </div>
                    <div class=" col-lg-3 col-sm-6 form-group">
                            <label for="city_id" class="es-required" data-error-next-to="0">@lang('City')</label>
                            @include(
                            'EscortAdmin::common.form.cities',
                            [
                            'name' => 'city_id',
                            'id' => 'city_id',
                            'value' => old('city_id', ''),
                            'placeholder' => true,
                            'disable_preloaded' => true
                            ]
                            )
                            @include('Admin::common.form.error', ['key' => 'city_id'])
                    </div>
                    <div class="col-lg-3 col-sm-6 form-group">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <label for="date_start" class="es-required">@lang('Start')</label>
                                <input type="text" class="form-control" name="date_start" id="date_start" placeholder="mm/dd/yyyy" value="{{ old('date_start') }}">
                                @include('Admin::common.form.error', ['key' => 'date_start'])
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label for="date_end" class="es-required">@lang('End')</label>
                                <input type="text" class="form-control" name="date_end" id="date_end" placeholder="mm/dd/yyyy" value="{{ old('date_end') }}">
                                @include('Admin::common.form.error', ['key' => 'date_end'])
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 form-group">
                        <label for="telephone" class="es-required">@lang('Telephone')</label>
                        <input class="form-control" type="text" id="telephone" name="telephone" value="{{ old('telephone', '') }}">
                        @include('Admin::common.form.error', ['key' => 'telephone'])
                    </div>
                    <div class="col-lg-6 col-sm-6 form-group">
                        <label for="phone_instructions" class="es-required">@lang('Phone Instructions')</label>
                        <input class="form-control" type="text" id="phone_instructions" name="phone_instructions" value="{{ old('phone_instructions', '') }}">
                        @include('Admin::common.form.error', ['key' => 'phone_instructions'])
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save">@lang('ADD')</button>
            </form>
        </div>
    </div>
</div>
@pushAssets('scripts.post')
<script>
    $(function() {
        var $dateStart = $('#date_start');
        var $dateEnd = $('#date_end');
        var $addTourForm = $('#add_tour_form');
        $addTourForm.submit(function() {
            $start = $dateStart.val();
            $end = $dateEnd.val();
            if ($start != '' && $end != '') {
                var $startDate = new Date($start);
                var $endDate = new Date($end);
                if ($startDate.getTime() > $endDate.getTime()) {
                    fnAlert('Start Date must be less than or equal to End Date.', function() {
                        $dateStart.focus();
                    });
                    return false;
                }
            }
            return true;
        });
    })
</script>
@endPushAssets