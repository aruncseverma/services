@if (! $escort)
    <div class="text-center"><strong>@lang('Requested user not found.')</strong></div>
@else
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" href="#basic_info_{{ $escort->getKey() }}" data-toggle="tab" role="tab" aria-selected="true">@lang('Basic Information')</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#personal_info_{{ $escort->getKey() }}" data-toggle="tab" role="tab" aria-selected="true">@lang('Personal Information')</a>
        </li>
    </ul>
    <div class="tab-content tabcontent-border">
        @include('Admin::escorts.components.view_info.basic_info')
        @include('Admin::escorts.components.view_info.personal_info')
    </div>
@endif
