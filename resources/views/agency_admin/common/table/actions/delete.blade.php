<button class="btn btn-danger btn-xs" title="{{ __('Delete') }}" data-delete-id="{{ $id }}" data-delete-to="{{ $to }}">
    <i class="mdi mdi-delete"></i>
</button>

@pushAssets('scripts.post')
    {{-- delete action --}}
    <script type="text/javascript">
        (function ($) {
            $('[data-delete-id]').on('click', function () {

                var action = $(this).data('delete-to');
                var id     = $(this).data('delete-id');

                swal({
                    title: '@lang("Delete?")',
                    text: '@lang("Are you sure? All changes done cannot be reverted.")',
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
    {{-- end delete action --}}
@endPushAssets
