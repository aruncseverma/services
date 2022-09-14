@php
$id = $id ?? '';
$btnId = $btnId ?? 'act_as_' . $id;
$btnText = $btnText ?? '';
$btnCls = $btnCls ?? 'btn btn-xs btn-info';
@endphp
<button id="{{ $btnId }}" class="{{ $btnCls }}" type="button" data-toggle="act-as" data-route="{{ $route }}" data-object-id="{{ $id }}" title="{{ __('Act as behalf') }}">
    <i class="mdi mdi-login"></i> {{ $btnText }}
</button>

@pushAssets('scripts.post')
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="act-as"]').on('click', function (e) {
                var id = $(this).data('object-id');
                var route = $(this).data('route');

                // create form element
                var $form = $('<form></form>');
                var $input = $('<input></input>');

                // append attributes
                $form.attr('action', route);
                $form.attr('method', 'POST');
                $form.attr('target', '_blank');

                // append input attributes
                $input.attr('type', 'hidden');
                $input.attr('name', 'id');
                $input.attr('value', id);

                // append form csrf field
                var $csrfField = $('<input></input>');
                $csrfField.attr('name', '_token');
                $csrfField.val($('meta[name="csrf-token"]').attr('content'));

                // append fields
                $form.append($csrfField);
                $form.append($input);

                // append form to body
                $(document.body).append($form);

                $form.submit();
            });
        });
    </script>
@endPushAssets
