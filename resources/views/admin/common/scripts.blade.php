<script src="{{ asset('assets/theme/admin/default/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/bootstrap-switch/bootstrap-switch.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/js/waves.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/js/custom.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/toast-master/js/jquery.toast.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/js/helper.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/js/growl.min.js') }}"></script>
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

    var pusher = new Pusher('{{ env("MIX_PUSHER_APP_KEY", "") }}', {
        cluster: '{{ env("PUSHER_APP_CLUSTER", "") }}',
        encrypted: true
    })

    var channel = pusher.subscribe('admin-channel')

    channel.bind('App\\Events\\Admin\\Notification\\NotifyAdmin', function(data) {
        notify('info', data.message, 10000)
    })

    channel.bind('App\\Events\\Admin\\Notification\\WarnAdmin', function(data) {
        notify('danger', data.message, 10000)
    })
</script>

{{-- assets --}}
@stackAssets('scripts.post')
{{-- end assets --}}