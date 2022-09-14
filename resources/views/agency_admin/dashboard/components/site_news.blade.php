<div class="card col-lg-3">
    <div class="card-header" data-toggle="collapse" data-target="#site_news">
        <div class="card-actions">
            <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
        </div>
        <span>@lang('Site News')</span>
    </div>
    <div class="card-body collapse show" id="site_news">
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    @include('AgencyAdmin::common.table.no_results', ['colspan' => 2])
                </tbody>
            </table>
        </div>
    </div>
</div>
