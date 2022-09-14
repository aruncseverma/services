<div class="col-md-6">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#ban_countries_card">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Ban Countries')</span>
        </div>
        <div class="card-header-sub">
            @lang('Select countries you want to ban')
        </div>
        <div class="card-body collapse show" id="ban_countries_card">

            {{-- notification --}}
            @if (old('notify') === 'ban_countries')
            @include('MemberAdmin::common.notifications')
            @endif
            {{-- end notification --}}

            <form method="POST" action="{{ route('member_admin.account_settings.ban_countries') }}">

                {{ csrf_field() }}

                @component('MemberAdmin::common.form.group', ['key' => 'ban_countries'])
                    @slot('input')
                        @include('MemberAdmin::common.form.country', [
                            'name' => 'ban_countries', 
                            'is_multiple' => true, 
                            'value' => $banIds ?? [],
                            'classes' => 'select2 form-control', 
                            'attributes' => 'data-live-search="true"'
                        ])
                    @endslot
                @endcomponent

                <button type="submit" class="btn btn-primary waves-effect waves-light button-save text-uppercase">@lang('Save')</button>

            </form>
        </div>
    </div>
</div>
