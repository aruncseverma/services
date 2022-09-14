<div class="card">
    <div class="card-header" data-toggle="collapse" data-target="#search" aria-expanded="true">
        <div class="card-actions">
            <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
        </div>
        <span>@lang('Search')</span>
    </div>

    <div class="card-body collapse" id="search" style="border: 1px solid #bfbfbf">
        <form action="{{ $action OR '' }}" method="GET">
            {{-- input --}}
            {{ $slot }}
            {{-- end input --}}
            <div class="form-actions">
                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> @lang('Search')</button>
                <a href="{{ $action OR '' }}" class="btn btn-danger"><i class="fa fa-trash"></i> @lang('Clear Search')</a>
            </div>
        </form>
    </div>
</div>
