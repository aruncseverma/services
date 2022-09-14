<div class="col-xl-20 panel panel-body">
    @if ($agency->profilePhotoUrl)
        <img src="{{ $agency->profilePhotoUrl }}" style="width:100%">
    @else
        <img src="{{ asset('assets/theme/index/default/images/index/user_image.png') }}" alt="user_image" title="user_image">
    @endif
</div>
@pushAssets('post.scripts')
<script type="text/javascript">
$(document).ready(function(){
    $('.required-login').on('click', function(){
        fn_set_notification('error', 'Please login to proceed');
    });
});
</script>
@endPushAssets
