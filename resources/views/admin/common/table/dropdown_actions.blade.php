<select class="action-dropdown custom-select col-12">
    <option value="" selected disabled>@lang('Select')</option>
    {{ $options ?? '' }}
    @if(isset($optionActions) && !empty($optionActions))
        @foreach($optionActions as $key => $value)
            @php
                $isShow = true;
                $actionId = $key;
                $actionLabel = $value;
                if (is_array($value)) {
                    $isShow = $value['show'] ?? $isShow;
                    $actionId = $value['id'] ?? '';
                    $actionLabel = $value['text'] ?? '';
                }
            @endphp

            @if($isShow)
            <option value="{{ $actionId }}">{{ $actionLabel }}</option>
            @endif
        @endforeach
    @endif
</select>
<div style="display:none;">
    {{ $slot ?? '' }}
</div>

@pushAssets('scripts.post')
<script>
    $(function() {
        console.log('asa');
        $listingActions = $('.action-dropdown');
        if ($listingActions.length) {
            $listingActions.change(function() {
                var $elm = $(this);
                var $val = $elm.val();
                // trigger click event to target element
                if ($val != '') {
                    var $target = $('#' + $val);
                    if ($target.length) {
                        $target[0].click();
                    }
                }
                // reset to default value
                $elm.val('');
            })
        }
    });
</script>
@endPushAssets