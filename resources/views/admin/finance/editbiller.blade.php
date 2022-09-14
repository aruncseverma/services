@if (! $biller)
    <div class="text-center"><strong>@lang('Requested biller not found.')</strong></div>
@else
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" href="#basic_info" data-toggle="tab" role="tab" aria-selected="true">@lang('Basic Information')</a>
        </li>
    </ul>
    <div class="tab-content tabcontent-border">
        @include('Admin::finance.components.biller_info')
    </div>
@endif
