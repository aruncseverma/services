<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#favagencylatest">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('My Favorite Agency Latest')</span>
            <button type="submit" class="btn btn-primary es es-redirect" data-href="{{ route('member_admin.favorite_escorts.manage') }}"><span class="action-button">VIEW ALL</span></button>
        </div>
        <div class="card-header-sub">
            @lang('Latest update from my favorite agencies')
        </div>
        <div class="card-body collapse show" id="favagencylatest">
            <div class="table-responsive m-t-40">
                <table class="table stylish-table">
                    <thead>
                        <tr>
                            <th colspan="2">@lang('Agency')</th>
                            <th>@lang('Date')</th>
                            <th>@lang('Updates')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestFavoriteAgencies as $fav)
                        <tr>
                            <td style="width:50px;"><span class="round"><img src="{{ $fav->escort->profilePhotoUrl ?? $noImageUrl }}" alt="user" width="50" /></span></td>
                            <td>
                                <h6>{{ $fav->agency->name ?? '' }}</h6>
                            </td>
                            <td>{{ $fav->date ?? '' }}</td>
                            <td>{{ $fav->agency->updates ?? 'No update' }}</td>
                        </tr>
                        @empty
                        @include('MemberAdmin::common.table.no_results', ['colspan' => 4])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>