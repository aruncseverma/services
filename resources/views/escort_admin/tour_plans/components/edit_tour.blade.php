@if ($id != '')
<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#edittour">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Edit Tour')</span>
        </div>
        <div class="card-header-sub">
            @lang('You can edit tour plan here')
        </div>
        <div class="card-body collapse show" id="edittour">
            <form action="{{ route('escort_admin.tour_plans.update') }}" method="POST" id="edit_tour_form" class="es es-validation">
                @csrf
                <input type="hidden" name="id" value="{{ $id ?? old('id') }}">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 form-group">
                        <label for="edit_continent_id" class="es-required" data-error-next-to="0">@lang('Continent')</label>
                        @include(
                        'EscortAdmin::common.form.continent',
                        [
                        'name' => 'edit_continent_id',
                        'id' => 'edit_continent_id',
                        'value' => $tourPlanData->continent_id ?? old('edit_continent_id'),
                        'target' => '#edit_country_id',
                        'placeholder' => true
                        ]
                        )
                        @include('Admin::common.form.error', ['key' => 'edit_continent_id'])
                    </div>
                    <div class="col-lg-3 col-sm-6 form-group">
                        <label for="edit_country_id" class="es-required" data-error-next-to="0">@lang('Country')</label>
                        @include(
                        'EscortAdmin::common.form.country',
                        [
                        'name' => 'edit_country_id',
                        'id' => 'edit_country_id',
                        'value' => $tourPlanData->country_id ?? old('edit_country_id'),
                        'target' => '#edit_state_id',
                        'placeholder' => true,
                        'disable_preloaded' => true
                        ]
                        )
                        @include('Admin::common.form.error', ['key' => 'edit_country_id'])
                    </div>
                    <div class="col-lg-3 col-sm-6 form-group">
                        <label for="edit_state_id" class="es-required" data-error-next-to="0">@lang('State')</label>
                        @include(
                        'EscortAdmin::common.form.states',
                            [
                                'name' => 'edit_state_id',
                                'id' => 'edit_state_id',
                                'value' => $tourPlanData->state_id ?? old('edit_state_id'),
                                'target' => '#edit_city_id',
                                'placeholder' => true,
                                'disable_preloaded' => true
                            ]
                        )
                        @include('Admin::common.form.error', ['key' => 'edit_state_id'])
                    </div>
                    <div class=" col-lg-3 col-sm-6 form-group">
                            <label for="edit_city_id" class="es-required" data-error-next-to="0">@lang('City')</label>
                            @include(
                            'EscortAdmin::common.form.cities',
                            [
                            'name' => 'edit_city_id',
                            'id' => 'edit_city_id',
                            'value' => $tourPlanData->city_id ?? old('edit_city_id'),
                            'placeholder' => true,
                            'disable_preloaded' => true
                            ]
                            )
                            @include('Admin::common.form.error', ['key' => 'edit_city_id'])
                    </div>
                    <div class="col-lg-3 col-sm-6 form-group">
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <label for="edit_date_start" class="es-required">@lang('Start')</label>
                                <input type="text" class="form-control" name="edit_date_start" id="edit_date_start" placeholder="mm/dd/yyyy" value="{{ $tourPlanData->date_start ?? old('edit_date_start') }}">
                                @include('Admin::common.form.error', ['key' => 'edit_date_start'])
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <label for="edit_date_end" class="es-required">@lang('End')</label>
                                <input type="text" class="form-control" name="edit_date_end" id="edit_date_end" placeholder="mm/dd/yyyy" value="{{ $tourPlanData->date_end ?? old('edit_date_end') }}">
                                @include('Admin::common.form.error', ['key' => 'edit_date_end'])
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 form-group">
                        <label for="edit_telephone" class="es-required">@lang('Telephone')</label>
                        <input class="form-control" type="text" id="edit_telephone" name="edit_telephone" value="{{ $tourPlanData->telephone ?? old('edit_telephone') }}">
                        @include('Admin::common.form.error', ['key' => 'edit_telephone'])
                    </div>
                    <div class="col-lg-6 col-sm-6 form-group">
                        <label for="edit_phone_instructions" class="es-required">@lang('Phone Instructions')</label>
                        <input class="form-control" type="text" id="edit_phone_instructions" name="edit_phone_instructions" value="{{ $tourPlanData->phone_instructions ?? old('edit_phone_instructions') }}">
                        @include('Admin::common.form.error', ['key' => 'edit_phone_instructions'])
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save">@lang('SAVE')</button>
            </form>
        </div>
    </div>
</div>
@endif

@pushAssets('scripts.post')
<script>
    $(function() {
        var $dateStart = $('#edit_date_start');
        var $dateEnd = $('#edit_date_end');
        var $editTourForm = $('#edit_tour_form');
        $editTourForm.submit(function() {
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