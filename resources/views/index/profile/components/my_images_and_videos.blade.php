<!--Horizontal Tab-->
<div id="parentHorizontalTab">
    <ul class="resp-tabs-list hor_1">
        <li>My Images</li>
        <li>My Videos</li>
    </ul>
    <div class="resp-tabs-container hor_1">
        <h2 class="resp-accordion hor_0 resp-tab-active" role="tab" aria-controls="hor_1_tab_item-0"><i class="fa fa-window-minimize"></i></h2>
        <div>
            <div class="col-xl-20 tabsimages">
                @if ($photos['public'])
                    <img src="{{ route('common.photo', ['photo' => $photos['public'], 'path'=> $photos['public']->path]) }}" style="width:100%">
                @else
                    <img src="{{ asset('assets/theme/index/default/images/index/user_image.png') }}" alt="user_image" title="user_image">
                @endif
            </div>
            <div class="row">
                <div class="col-xs-20">
                    <a data-toggle="collapse" href="#uncensored_photos" role="button" aria-expanded="false" aria-controls="uncensored_photos" @if (empty($auth)) class="required-login" @endif >MY UNCENSORED PHOTOS</a>
                </div>
                @if (!empty($auth))
                    <div class="col-xs-20 tabsimages collapse" id="uncensored_photos">
                        @if ($photos['private'])
                            <img src="{{ route('common.photo', ['photo' => $photos['private'], 'path'=> $photos['private']->path]) }}" style="width:100%">
                        @else
                            <img src="{{ asset('assets/theme/index/default/images/index/prof3.jpg') }}" alt="prof3" title="prof3">
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <h2 class="resp-accordion hor_1" role="tab" aria-controls="hor_1_tab_item-1"><i class="fa fa-window-maximize"></i></h2>
        <div>
            <div class="col-xl-20 tabsimages">
                @if (isset($videos['public']['id']))
                    <video src="{{ route('common.video', ['id' => $videos['public']['id']]) }}" controls controlsList="nodownload" style="width:100%"></video>
                @else
                    <img src="{{ asset('assets/theme/index/default/images/index/user_image.png') }}" alt="user_image" title="user_image">
                @endif
            </div>
            <div class="row">
                <div class="col-xs-20">
                    <a data-toggle="collapse" href="#uncensored_videos" role="button" aria-expanded="false" aria-controls="uncensored_videos" @if (empty($auth)) class="required-login" @endif >MY UNCENSORED VIDEOS</a>
                </div>
                @if (!empty($auth))
                    <div class="col-xs-20 tabsimages collapse" id="uncensored_videos">
                        @if (isset($videos['private']['id']))
                            <video src="{{ route('common.video', ['id' => $videos['private']['id']]) }}" controls controlsList="nodownload" style="width:100%"></video>
                        @else
                            <img src="{{ asset('assets/theme/index/default/images/index/prof3.jpg') }}" alt="prof3" title="prof3">
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
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
