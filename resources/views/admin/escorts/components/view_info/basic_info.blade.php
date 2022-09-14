<div class="tab-pane active" id="basic_info_{{ $escort->getKey() }}">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>@lang('Field')</th>
                <th>@lang('Value')</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>@lang('ID')</td>
                <td>{{ $escort->getKey() }}</td>
            </tr>
            <tr>
                <td>@lang('Name')</td>
                <td>{{ $escort->name ?? __('Not Specified') }}</td>
            </tr>
            <tr>
                <td>@lang('Email Address')</td>
                <td><a href="mailto:{{ $escort->email }}">{{ $escort->email }}</a></td>
            </tr>
            <tr>
                <td>@lang('Username')</td>
                <td>{{ $escort->username }}</td>
            </tr>
            <tr>
                <td>@lang('Phone')</td>
                <td>{{ $escort->phone ?? __('Not Specified') }}</td>
            </tr>
            <tr>
                <td>@lang('Origin')</td>
                <td>{{ $escort->origin ?? __('Not Specified') }}</td>
            </tr>
            <tr>
                <td>@lang('Age')</td>
                <td>{{ $escort->age ?? __('Not Specified') }}</td>
            </tr>
            <tr>
                <td>@lang('Approval Status')</td>
                <td>
                    @if ($escort->isApproved())
                        @lang('Approved')
                    @else
                        @lang('Pending')
                    @endif
                </td>
            </tr>
            <tr>
                <td>@lang('Email Verification Status')</td>
                <td>
                    @if ($escort->isVerified())
                        @lang('Verified')
                    @else
                        @lang('Not Verified')
                    @endif
                </td>
            </tr>
            <tr>
                <td>@lang('Profile Status')</td>
                <td>
                    @if ($escort->isBlocked())
                        @lang('Blocked')
                    @elseif ($escort->isActive())
                        @lang('Active')
                    @else
                        @lang('Inactive')
                    @endif
                </td>
            </tr>
            <tr>
                <td>@lang('Account Type')</td>
                <td>
                    @if ($escort->agency)
                        @lang('Escort Agency')
                    @else
                        @lang('Independent')
                    @endif
                </td>
            </tr>
            <tr>
                <td>@lang('Created At')</td>
                <td>{{ $escort->getAttribute($escort->getCreatedAtColumn()) }}</td>
            </tr>
        </tbody>
    </table>
</div>
