<div class="card">
    <img class="card-img-top img-fluid" src="{{ $escort->profilePhotoUrl ?? asset('assets/theme/admin/default/images/escort_placeholder.png') }}" alt="Card image cap">

    <div class="card-body">
        @if ($location = $escort->mainLocation)
            <i class="flag-icon flag-icon-{{ strtolower($location->country->code) }}"></i>
        @endif
        <h4 class="card-title">{{ $escort->name }}</h4>
        <p class="card-text">
            {{-- verified status --}}
            @if ($escort->isVerified())
                <button class="btn btn-outline-success waves-effect waves-light text-uppercase" type="button">
                    @lang('Verified')
                </button>
            @else
                <button class="btn btn-outline-secondary waves-effect waves-light text-uppercase" type="button">
                    @lang('Get Verified')
                </button>
            @endif
            {{-- end --}}

            {{-- approval status --}}
            @if ($escort->isApproved())
                <button class="btn btn-outline-success waves-effect waves-light text-uppercase" type="button">
                    @lang('Approved')
                </button>
            @else
                <button class="btn btn-outline-secondary waves-effect waves-light text-uppercase" type="button">
                    @lang('Get Approved')
                </button>
            @endif
            {{-- end --}}
        </p>
        <div class="icons">
            <a href="{{ route('agency_admin.escort.update', ['id' => $escort->username]) }}" class="btn btn-primary"><i class="mdi mdi-account-edit"></i></a>
            <a href="{{ route('agency_admin.emails.compose', ['id' => $escort->email]) }}" target="_blank" class="btn btn-primary" ><i class="fa fa-envelope-o"></i></a>
            <a href="{{ route('agency_admin.reviews', ['escort_id' => $escort->username]) }}" target="_blank" class="btn btn-primary"><i class="mdi mdi-format-quote"></i></a>
            <button type="button" class="btn btn-primary" disabled><i class="mdi mdi-file-document"></i></button>
            <button type="button" class="btn btn-primary" data-toggle="remove_escort" data-action="{{ route('agency_admin.escort.remove', ['escort' => $escort->username]) }}"><i class="mdi mdi-delete-forever"></i></button>
        </div>
    </div>
</div>

@pushAssets('scripts.post')
<script type="text/javascript">
    $(function() {
        $('[data-toggle="remove_escort"]').on('click', function() {
            var $target = $(this);
            swal({
                title: 'Remove?',
                text: 'Are you sure? All changes done cannot be reverted.',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: 'Yes',
            }, function () {
                setTimeout(function () {
                    // create elment form
                    var $form = $('<form></form>');

                    // append information
                    $form.attr('action', $target.data('action'));
                    $form.attr('method', 'POST');
                    $form.append($('<input></input>').attr('name', '_token').val($('meta[name="csrf-token"]').attr('content')));

                    // append to form
                    $(document.body).append($form);

                    // submit
                    $form.submit();
                }, 50);
            });
        });
    });
</script>
@endPushAssets
