<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#locality">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Locality')</span>
        </div>
        <div class="card-header-sub">
            @lang('Please pinpoint your location')
        </div>
        <div class="card-body collapse show" id="locality">
            <form action="{{ route('escort_admin.profile.geo_location') }}" method="POST">
                @csrf
                <div id="geo_location" class="gmaps"></div>
                <input type="hidden" id="geo_location_lat" name="geo_location_lat" value="{{ $user->geoLocation->lat ?? '' }}">
                <input type="hidden" id="geo_location_long" name="geo_location_long" value="{{ $user->geoLocation->long ?? '' }}">
                @include('Admin::common.form.error', ['key' => 'geo_location_lat'])
                @include('Admin::common.form.error', ['key' => 'geo_location_long'])
                <br />
                <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save">@lang('SAVE')</button>
            </form>
        </div>
    </div>
</div>
