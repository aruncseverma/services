<div class="tab-pane" id="personal_info_{{ $escort->getKey() }}">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>@lang('Field')</th>
                <th>@lang('Value')</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>@lang('Availability')</td>
                <td>N/A</td>
            </tr>
            <tr>
                <td>@lang('Bust Size')</td>
                <td>{{ ($escort->userData->bustId) ? sprintf('%dcm', $escort->userData->bustId) : 'N/A' }}</td>
            </tr>
            <tr>
                <td>@lang('Languages')</td>
                <td>{{ $languageDesc ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>@lang('Service Categories')</td>
                <td>{{ $categoriesDesc ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>@lang('Ethnicity')</td>
                <td>{{ $escort->ethnicity ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>@lang('Cup Size')</td>
                <td>{{ $escort->cupSize ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>@lang('Hair Color')</td>
                <td>{{ $escort->hairColor ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>@lang('Eye Color')</td>
                <td>{{ $escort->eyeColor ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>@lang('Height')</td>
                <td>{{ ($escort->userData->heightId) ? sprintf('%dcm', $escort->userData->heightId) : 'N/A' }}</td>
            </tr>
            <tr>
                <td>@lang('Weight')</td>
                <td>{{ ($escort->userData->weightId) ? sprintf('%dlbs', $escort->userData->weightId) : 'N/A' }}</td>
            </tr>
        </tbody>
    </table>
</div>
