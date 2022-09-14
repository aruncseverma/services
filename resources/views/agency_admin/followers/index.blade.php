@extends('AgencyAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-account-multiple-outline"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#allfollowers">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('List of Agency Followers')</span>
        </div>
        <div class="card-body collapse show" id="allfollowers">
            @if (old('notify') == 'agency_followers')
                @include('AgencyAdmin::common.notifications')
            @endif
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="132" style="min-width: 132px" class="text-uppercase">@lang('name')</th>
                            <th style="min-width: 244px"></th>
                            <th width="212" style="min-width: 212px"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($agencyFollowers as $follower)
                        @include(
                            'AgencyAdmin::followers.components.follower',
                            [
                                'followers' => $agencyFollowers,
                                'showFollowerRatingAction' => true,
                                'notify' => 'agency_followers'
                            ]
                        )
                    @empty
                        @include('AgencyAdmin::common.table.no_results', ['colspan' => 3])
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{ $agencyFollowers->links('pagination::agency_admin.pagination') }}
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#all_model_followers">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('List of Models Followers')</span>
        </div>
        <div class="card-body collapse show" id="all_model_followers">
            @if (old('notify') == 'escorts_followers')
                @include('AgencyAdmin::common.notifications')
            @endif
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="132" style="min-width: 132px" class="text-uppercase">@lang('name')</th>
                            <th style="min-width: 244px"></th>
                            <th width="212" style="min-width: 212px"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($escortsFollowers as $follower)
                        @include(
                            'AgencyAdmin::followers.components.follower',
                            [
                                'followers' => $escortsFollowers,
                                'showFollowerRatingAction' => false,
                                'notify' => 'escorts_followers'
                            ]
                        )
                    @empty
                        @include('AgencyAdmin::common.table.no_results', ['colspan' => 3])
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{ $agencyFollowers->links('pagination::agency_admin.pagination') }}
        </div>
    </div>
</div>
@endsection
