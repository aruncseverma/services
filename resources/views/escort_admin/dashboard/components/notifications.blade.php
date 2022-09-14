@php
    $events = [
        'RevokeVip' => [
            'title' => 'VIP Status has been Revoked!',
            'type' => 'alert-danger',
            'message' => "Your VIP Status has been revoked due to %s"
        ],
        'GrantVip' => [
            'title' => 'VIP Status has been Granted!',
            'type' => 'alert-success',
            'message' => "Your VIP Request with order number %s has been approved"
        ]
    ];
@endphp
<div class="col-md-12">
@foreach($unreadNotifications as $notif)

    @php
        $type = 'alert-success';
        $title = '';
        $message = '';
        $text = '';
        $icon = '';


        if(strpos($notif->type, 'RevokeVip')) {
            $title = 'VIP Status has been Revoked!';
            $type = 'alert-danger';
            $text = 'text-danger';
            $icon = 'fa fa-warning';
            $message = sprintf('Your VIP Status has been revoked due to following reason(s): <b>%s</b>', $notif->data['reason']);
        }

        /**
         * ICONS:
         * ----------------------------------
         * fa fa-check-circle
         * fa fa-warning
         * fa fa-info-circle
         * fa fa-warning
         */

    @endphp
    <div class="col-md-12">
        <div class="alert {{ $type }}">
            <a  href="#" 
                class="close"
                data-id="{{ $notif->id }}"
                data-dismiss="alert" 
                aria-label="Close"> 
                <span aria-hidden="true">×</span> 
            </a>

            <h3 class="{{ $text }}"><i class="{{ $icon }}"></i> {{ $title }} </h3>
            {!! $message !!}
        </div>
    </div>
@endforeach
</div>

@pushAssets('scripts.post')
<script type="text/javascript">
    $('.close').on('click', function(e) {
        e.preventDefault()

        var url = "{{ route('escort_admin.notification.read') }}"
        var id = $(this).data('id')

        var formData = new FormData()
        formData.append('id', id)

        $.ajax(url, {
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'JSON',
            success: function(data) {},
            error: function(error) {
                console.log(error)
            }
        })
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
@endPushAssets