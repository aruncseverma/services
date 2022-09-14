@if ($showFollowerRatingAction)
    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-star"></i>&nbsp;@lang('Rate Follower')
    </button>
    <div class="dropdown-menu">
        @for ($i = 1; $i <= 5; $i++)
            @if ($follower->getAttribute('follower_user_rating') == $i)
                <a class="dropdown-item text-warning">
            @else
                <a class="dropdown-item" href="{{ route('agency_admin.follower.rate',[
                    'follower'=> $follower->getKey(),
                    'rate' => $i
                ])}}">
            @endif
                @for ($a = 1; $a <= 5; $a++)
                    @if ($a <= $i)
                        <i class="fa fa-star"></i>
                    @else
                        <i class="fa fa-star-o"></i>
                    @endif
                @endfor
            </a>
        @endfor
    </div>
@endif
<a href="#" data-toggle="delete_follower" data-action="{{ route('agency_admin.follower.delete', ['follower' => $follower->getKey(), 'notify' => $notify]) }}">
    <i class="mdi mdi-delete"></i>
</a>

@pushAssets('scripts.post')
<script type="text/javascript">
    $(function() {
        $('[data-toggle="delete_follower"]').on('click', function (e) {
            var action = $(this).data('action');
            if (action) {
                swal({
                    title: '@lang("Delete?")',
                    text: '@lang("Are you sure? All changes done cannot be reverted.")',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "@lang('Yes')",
                    closeOnConfirm: true
                }, function () {
                    var $form = $('<form></form>');
                    $form.attr('action', action);
                    $form.attr('method', 'POST');
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
                });
            }
            return false;
        });
    });
</script>
@endPushAssets
