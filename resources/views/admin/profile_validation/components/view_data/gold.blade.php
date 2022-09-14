<table class="table table-bordered table-striped">
    <tr>
        <td>@lang('Real Name')</td>
        <td>{{ $info['name'] ?? '' }}</td>
    </tr>
    <tr>
        <td>@lang('Real Birthdate')</td>
        <td>{{ $info['birthdate'] ?? '' }}</td>
    </tr>
    <tr>
        <td>@lang('Real Email')</td>
        <td>{{ $info['email'] ?? '' }}</td>
    </tr>
    <tr>
        <td>@lang('Real Telephone')</td>
        <td>{{ $info['tel'] ?? '' }}</td>
    </tr>
    <tr>
        <td>@lang('Emergency Contact Number')</td>
        <td>{{ $info['emergency_tel'] ?? '' }}</td>
    </tr>
    <tr>
        <td>@lang('Photo ID')</td>
        <td>
            <img class="img-thumbnail" src="data:{{ $photo['mime'] }};base64,{{ base64_encode($photo['raw']) }}" width="360">
        </td>
    </tr>
</table>
