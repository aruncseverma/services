@php
$dateId = $id ?? 'date_range';
$dateStartName = $name_start ?? 'date_range_start';
$dateEndName = $name_end ?? 'date_range_end';
$dateStartValue = $value_start ?? '';
$dateEndValue = $value_end ?? '';
$dateRemoveId = $dateId . '_remove';
@endphp

<div class="input-daterange input-group" id="{{ $dateId }}">
    <input type="text" class="input-sm form-control" name="{{ $dateStartName }}" value="{{ $dateStartValue }}" autocomplete="off" readonly />
    <span class="input-group-text" style="border-radius: 0;border-right: 0;border-left: 0;">to</span>
    <input type="text" class="input-sm form-control" name="{{ $dateEndName }}" value="{{ $dateEndValue }}" autocomplete="off" readonly />
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" id="{{ $dateRemoveId }}"><i class="fa fa-times" aria-hidden="true"></i></button>
    </div>
</div>

@pushAssets('styles.post')
<!-- Date picker plugins css -->
<link href="{{ asset('assets/theme/admin/default/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endPushAssets

@pushAssets('scripts.post')
<!-- Date Picker Plugin JavaScript -->
<script src="{{ asset('assets/theme/admin/default/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var $dateRange = $('#{{ $dateId }}');
        $dateRange.datepicker({});

        $('#{{ $dateRemoveId }}').click(function() {
            $dateRange.find('input.form-control').val('');
        });
    });
</script>
@endPushAssets