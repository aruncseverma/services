<div class="col-md-6">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#schedules">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('My Schedule')</span>
        </div>
        <div class="card-header-sub">
            @lang('Manage your schedules')
        </div>
        <div class="card-body collapse show" id="schedules">
            @if (old('notify') === 'schedules')
                @include('EscortAdmin::common.notifications')
            @endif
            <form method="POST" action="{{ route('escort_admin.rates_services.update_schedules') }}" id="schedules_form">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>@lang('Duration')</th>
                                <th>@lang('From')</th>
                                <th>@lang('Till')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($days as $day => $desc)
                                <tr>
                                    <td>
                                        <span class="schedules-duration">{{ $desc }}</span>
                                        @include('EscortAdmin::common.form.error', ['key' => "schedules"])
                                    </td>
                                    <td>
                                        <select class="selectpicker schedules-from" data-container="body" data-style="form-drop" name="schedules[{{ $day }}][from]">
                                            @for ($i = 0; $i <= 24; $i++)
                                                <option @if ($escort->hasSchedule($day, sprintf('%02d:00', $i), 'from')) selected="" @endif)>{{ sprintf('%02d:00', $i) }}</option>
                                            @endFor
                                        </select>
                                    </td>
                                    <td>
                                        <select class="selectpicker schedules-to" data-container="body" data-style="form-drop" name="schedules[{{ $day }}][till]">
                                            @for ($i = 0; $i <= 24; $i++)
                                                <option @if ($escort->hasSchedule($day, sprintf('%02d:00', $i), 'till')) selected="" @endif)>{{ sprintf('%02d:00', $i) }}</option>
                                            @endFor
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ csrf_field() }}
                <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save text-uppercase">@lang('Save')</button>
            </form>
        </div>
    </div>
</div>

@pushAssets('scripts.post')
<script>
$(function(){
    var $scheduleDurations = $('.schedules-duration');
    var $schedulesFrom = $('.schedules-from');
    var $schedulesTo = $('.schedules-to');
    var $totalLen = $scheduleDurations.length;
    var $schedulesForm = $('#schedules_form');
    $schedulesForm.submit(function(){
        for (var i = 0; i < $totalLen; ++i) {
            var $fromVal = parseInt($schedulesFrom.eq(i).val());
            var $toVal = parseInt($schedulesTo.eq(i).val());
            if ($fromVal > 0 && $toVal > 0 && $fromVal > $toVal) {
                fnAlert($scheduleDurations.eq(i).text()+ ' "From" value must be less than or equal to "Till" value.', function(){
                    $schedulesFrom.eq(i).focus();
                });
                return false;
            }
        }
    });
})
</script>

@endPushAssets