<!-- My Tours -->
<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#mytours">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>My Tour Plans</span>
        </div>
        <div class="card-body collapse show" id="mytours">
             <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="th-small">START</th>
                                <th class="th-small">END</th>
                                <th class="th-small">CONTINENT</th>
                                <th class="th-medium">COUNTRY</th>
                                <th class="th-medium">STATE</th>
                                <th class="th-medium">CITY</th>
                                <th class="th-medium" style="min-width:144px">PHONE</th>
                                <th width="48" style="min-width: 48px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($user->tourPlans as $tourPlan)
                                <tr>
                                    <td>{{ $tourPlan->date_start ?? '' }}</td>
                                    <td>{{ $tourPlan->date_end ?? '' }}</td>
                                    <td>{{ $tourPlan->continent->name ?? '' }}</td>
                                    <td>{{ $tourPlan->country->name ?? '' }}</td>
                                    <td>{{ $tourPlan->state->name ?? '' }}</td>
                                    <td>{{ $tourPlan->city->name ?? '' }}</td>
                                    <td>{{ $tourPlan->telephone ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('escort_admin.tour_plans', [
                                        'id' => $tourPlan->id ])}}#edittour"><i class="mdi mdi-pencil-box-outline"></i></a>
                                        <a href="{{ route('escort_admin.tour_plans.delete', [
                                        'id' => $tourPlan->id ])}}" class="es es-confirm" data-title="Delete?"><i class="mdi mdi-delete"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" align="center">@lang('No data')</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
         </div>
             
    </div>
</div>
