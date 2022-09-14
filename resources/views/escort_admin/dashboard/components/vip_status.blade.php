@if (count($escort->memberships) == 0)
<div class="col-lg-12">
    <div class="card">
    <div class="card-header" data-toggle="collapse" data-target="#membership-feat">
        <div class="card-actions">
            <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
        </div>
        <span>{{ __('Your Membership: BASIC') }}</span>
        <a href="{{ route('escort_admin.vip.home') }}" class="btn btn-primary pull-right"><span class="action-button">{{ __('UPGRADE TO VIP NOW') }}</span></a>
    </div>
    <div class="card-header-sub">
        {{ __('Get VIP membership') }}
    </div>
    <div class="card-body collapse show" id="membership-feat">
        <div class="row">
            <div class="col-md-4 mem-feat">
                <img src="{{ asset('assets/theme/admin/default/images/vip_membership.jpg') }}" style="width: 100%" />
            </div>
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-striped table-mem-feat">
                        <thead>
                            <tr>
                                <th class="th-medium">{{ __('FEATURES') }}</th>
                                <th class="th-small">{{ __('STANDARD') }}</th>
                                <th class="th-small"><i class="mdi mdi-crown"></i>{{ __('VIP') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ __('Priority Listing') }}</td>
                                <td><i class="mdi mdi-close"></i></td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('First') }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('Direct Booking') }}</td>
                                <td><i class="mdi mdi-close"></i></td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('Yes') }}</td>
                            </tr><tr>
                                <td>{{ __('Upload Photos') }}</td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('3 Photos') }}</td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('Upload Unlimited') }}</td>
                            </tr><tr>
                                <td>{{ __('Upload Videos') }}</td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('5 Videos') }}</td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('Upload Unlimited') }}</td>
                            </tr><tr>
                                <td>{{ __('Manage Schedule') }}</td>
                                <td><i class="mdi mdi-close"></i></td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('Yes') }}</td>
                            </tr><tr>
                                <td>{{ __('Set Happy Hour') }}</td>
                                <td><i class="mdi mdi-close"></i></td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('Yes') }}</td>
                            </tr><tr>
                                <td>{{ __('Update Status (My Wall)') }}</td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('Limited') }}</td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('Updates Unlimited') }}</td>
                            </tr><tr>
                                <td>{{ __('Create Website') }}</td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('Basic') }}</td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('Advanced Features') }}</td>
                            </tr><tr>
                                <td>{{ __('Email Messaging') }}</td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('Limited') }}</td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('Unlimited Emails') }}</td>
                            </tr><tr>
                                <td>{{ __('Manage Shop') }}</td>
                                <td>x</td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('Yes') }}</td>
                            </tr><tr>
                                <td>{{ __('Customer Blacklist') }}</td>
                                <td><i class="mdi mdi-close"></i></td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('Yes') }}</td>
                            </tr><tr>
                                <td>{{ __('Show Services') }}</td>
                                <td><i class="mdi mdi-close"></i></td>
                                <td><i class="mdi mdi-checkbox-marked-outline"></i> {{ __('Yes') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <a href="{{ route('escort_admin.vip.home') }}" class="btn btn-outline-danger waves-effect waves-light button-save">{{ __('UPGRADE TO VIP NOW') }}</a>
    </div>
</div>
</div>
@else
<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#membership-stat">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>{{ __('Your Membership:') }} VIP</span>
            <a href="{{ route('escort_admin.vip.home') }}" class="btn btn-primary pull-right"><span class="action-button">{{ __('ADD MORE TO VIP') }}</span></a>
        </div>
        <div class="card-header-sub">
            {{ __('Your Membership Status') }}
        </div>
        <div class="card-body collapse show" id="membership-stat">
            <div class="table-responsive m-b-20">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>
                                {{ __('Your Membership Status:') }} <span class="label label-warning p-t-10"><h4 class="text-danger">VIP</h4></span>
                            </td>
                            <td>
                                FROM: {{ $escort->getActiveMembershipPlan($escort->getKey())->date_paid }}
                            </td>
                            <td>
                                UNTIL: {{ $escort->getActiveMembershipPlan($escort->getKey())->expiration_date }}
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
            <a href="{{ route('escort_admin.vip.home') }}" class="btn btn-outline-danger waves-effect waves-light button-save">{{ __('ADD MORE TO VIP') }}</a>
        </div>
    </div>
</div>
@endif