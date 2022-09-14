@php
$id = $id ?? '';
$btnId = $btnId ?? 'block_account_' . $id;
@endphp
@if ($isBlocked)
    <button id="{{ $btnId }}" class="btn btn-warning btn-xs" title="{{ __('Unblock Account') }}" data-blocked-account-id="{{ $id }}" data-blocked-account-to="{{ $to }}">
        <i class="fa fa-circle-o"></i>
    </button>
@else
    <button id="{{ $btnId }}" class="btn btn-warning btn-xs" title="{{ __('Block Account') }}" data-blocked-account-id="{{ $id }}"data-blocked-account-to="{{ $to }}">
        <i class="fa fa-circle"></i>
    </button>
@endif

@pushAssets('scripts.post')
    {{-- account block --}}
    <script type="text/javascript">
        (function ($) {
            $('[data-blocked-account-id]').on('click', function () {

                var action = $(this).data('blocked-account-to');
                var id     = $(this).data('blocked-account-id');

                swal({
                    title: '@lang("Confirm Action")',
                    text: '@lang("Are you sure to unblock/block this account?")',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "@lang('Yes')",
                    closeOnConfirm: true
                }, function () {
                    var $form  = $('<form></form>');
                    var $input = $('<input></input>');

                    // set input attributes
                    $input.attr('name', 'id');
                    $input.val(id);

                    // set form attributes
                    $form.attr('action', action);
                    $form.attr('method', 'POST');
                    $form.append($input);

                    // append form csrf field
                    var $csrfField = $('<input></input>');

                    // set attributes
                    $csrfField.attr('name', '_token');
                    $csrfField.val($('meta[name="csrf-token"]').attr('content'));

                    // append csrf
                    $form.append($csrfField);

                    // append form to body
                    $(document.body).append($form);

                    // submit form
                    $form.submit();
                    // console.log($form);
                });
            });
        })($);
    </script>
    {{-- end account block --}}
@endPushAssets
