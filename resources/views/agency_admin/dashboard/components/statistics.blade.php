<div class="card col-lg-3">
    <div class="card-header" data-toggle="collapse" data-target="#statistics">
        <div class="card-actions">
            <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
        </div>
        <span>@lang('Statistics')</span>
    </div>
    <div class="card-body collapse show" id="statistics">
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <td>@lang('Ranking')</td>
                        <td><span class="pull-right">{{ $ranking ?? 0 }}</span></td>
                    </tr>
                    <tr>
                        <td>@lang('Profile Views') </td>
                        <td><span class="pull-right">{{ $profileViews ?? 0 }}</span></td>
                    </tr>
                    <tr>
                        <td>@lang('Rating')</td>
                        <td><span class="pull-right">{{ $rating ?? 0 }}/5</span></td>
                    </tr>
                    <tr>
                        <td>@lang('Followers')</td>
                        <td><span class="pull-right">{{ number_format($followers) }}</span></td>
                    </tr>
                    <tr>
                        <td>@lang('Reviews')</td>
                        <td><span class="pull-right">{{ number_format($reviews) }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>