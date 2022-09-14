@if (!$package)
    <div class="text-center"><strong>@lang('Requested package not found.')</strong></div>
@else
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" href="#basic_info" data-toggle="tab" role="tab" aria-selected="true">@lang('Basic Information')</a>
        </li>
    </ul>
    <div class="tab-content tabcontent-border">
        @include('Admin::finance.components.package_info')
    </div>
@endif
