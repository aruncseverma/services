<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#all_escort_reviews">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Latest Escorts Reviews')</span>
            <button type="submit" class="btn btn-primary" id="elm_view_escort_reviews" data-href="{{ route('agency_admin.reviews') }}"><span class="action-button text-uppercase">@lang('View All Escort Reviews')</span></button>
        </div>

        <div class="card-body collapse show" id="all_escort_reviews">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="th-small text-uppercase">@lang('Date')</th>
                            <th class="th-small text-uppercase">@lang('Time')</th>
                            <th class="th-small text-uppercase">@lang('User')</th>
                            <th class="th-medium text-uppercase">@lang('Rating')</th>
                            <th class="text-uppercase">@lang('Review')</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($reviews as $review)
                            <td>{{ $review->date ?? '' }}</td>
                            <td>{{ $review->time ?? '' }}</td>
                            <td>{{ $review->user->name ?? '' }}</td>
                            <td>
                                @for ($a = 1; $a <= 5; $a++)
                                    @if ($a <= ($rate = $review->rating))
                                        <i class="fa fa-star @if ($rate < 1) fa-star-half-full @else fa-star @endif text-warning"></i>
                                    @else
                                        <i class="fa fa-star-o text-warning"></i>
                                    @endif
                                @endfor
                            </td>
                            <td>
                                {{ $review->content ?? '' }}
                            </td>
                            <td class="td-icons">
                                <a href="{{ route('agency_admin.reviews', ['id' => $review->getKey()]) }}"><i class="mdi mdi-magnify"></i></a>
                            </td>
                        @empty
                            @include('AgencyAdmin::common.table.no_results', ['colspan' => 5])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@pushAssets('scripts.post')
    <script type="text/javascript">
        $(function() {
            $('#elm_view_escort_reviews').on('click', function () {
                location.href = $(this).data('href');
            });
        });
    </script>
@endPushAssets
