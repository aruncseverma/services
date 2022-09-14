<script src="{{ asset('assets/theme/admin/default/plugins/jquery/jquery.min.js') }}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/js/waves.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
{{--<script src="{{ asset('assets/theme/admin/default/js/custom.min.js') }}"></script>--}}
<script src="{{ asset('assets/theme/admin/default/js/custom.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/toast-master/js/jquery.toast.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/js/helper.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/js/growl.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/draggable-bootstrap-grid/dist/jquery.gridstrap.min.js')}}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/mklb/js/mklb.js')}}"></script>
<script src="https://js.pusher.com/3.1/pusher.min.js"></script>
<script type="text/javascript">
    $(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
    var radioswitch = function() {
        var bt = function() {
            $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioState")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")
            }), $(".radio-switch").on("switch-change", function() {
                $(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)
            })
        };
        return {
            init: function() {
                bt()
            }
        }
    }();
    $(document).ready(function() {
        radioswitch.init()
        // For select 2
        $(".select2").select2();
        // $('.selectpicker').selectpicker();
    });

    // attach token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#eurPackages tbody tr').click(function() {
        $(this).addClass('bg-info').siblings().removeClass('bg-info');
        selectedPackage = this.id;
    });

    $('#usdPackages tbody tr').click(function() {
        $(this).addClass('bg-info').siblings().removeClass('bg-info');
        selectedPackage = this.id;
    });

    var pusher = new Pusher('{{ env("MIX_PUSHER_APP_KEY", "") }}', {
        cluster: '{{ env("PUSHER_APP_CLUSTER", "") }}',
        encrypted: true
    })

    console.log(pusher)

    var userId = "{!! Auth::user() != null ? Auth::user()->id : '' !!}"
    var channel = pusher.subscribe('escort-channel-' + userId)
    var fileChannel = pusher.subscribe('file-channel-' + userId)

    channel.bind('App\\Events\\EscortAdmin\\Notification\\NotifyEscort', function(data) {
        notify('info', data.message, 10000)
    })

    channel.bind('App\\Events\\EscortAdmin\\Notification\\WarnEscort', function(data) {
        notify('danger', data.message, 10000)
    })

    fileChannel.bind('App\\Events\\EscortAdmin\\File\\UploadStart', function(data) {
        $('#renderProgress').show()
    })

    fileChannel.bind('App\\Events\\EscortAdmin\\File\\UploadProgress', function(data) {

        if (data.type === 'public') {
            $('#publicProgress').html(data.progress + '%')

            if (data.progress >= 100) {
                // $('#uploadProgress').hide()
                $('#publicMessage').html('Render Complete')
                $('#publicProgress').html('100%')
            }
        } else {
            $('#privateProgress').html(data.progress + '%')

            if (data.progress >= 100) {
                // $('#uploadProgress').hide()
                $('#privateMessage').html('Render Complete')
                $('#privateProgress').html('100%')
            }
        }
    })

    fileChannel.bind('App\\Events\\EscortAdmin\\File\\UploadComplete', function(data) {
        if (data.type === 'public') {
            $('#publicProgress').html("100%")
        } else {
            $('#privateProgress').html("100%")
        }

        location.reload()
    })

    fileChannel.bind('App\\Events\\EscortAdmin\\File\\UploadFailed', function(data) {
        $('#renderPercent').html(data.error)
        $('#renderPercent').prop('style', 'width: 100%')
    })
</script>

{{-- assets --}}
@stackAssets('scripts.post')
{{-- end assets --}}