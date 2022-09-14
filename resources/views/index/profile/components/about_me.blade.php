<!-- about me -->
<div class="col-xs-20 col-md-10 panel-about">
    <div class="panel panel-primary"> 
        <div class="panel-heading widget_header widget_accordian_title"> 
            <a class="btn-minimize"><i class="fa fa-window-minimize"></i></a>
            <h3 class="panel-title">About Me</h3> 
        </div>
        <div class="panel-body widget_accordian_content" style="min-height: 170px;">
            @if ($shortAboutMe)
                <span style="display: block; margin-bottom: 38px;word-break: break-word;" id="short_about_me">{{ $shortAboutMe }}<br /></span>
                <span style="display: none; margin-bottom: 38px;word-break: break-word;" id="full_about_me">{{ $user->description->content ?? '' }}<br /></span>
                <a class="defualt_btn" href="#" style="border: none; text-decoration: none;" id="read_more">
                    <span>READ MORE</span>
                </a>

                @pushAssets('post.scripts')
                    <script type="text/javascript">
                        $(document).ready(function(){
                            var $read_more = $('#read_more');
                            var $short_about_me = $('#short_about_me');
                            var $full_about_me = $('#full_about_me');
                            $read_more.on('click', function(){
                                $short_about_me.hide();
                                $full_about_me.show();
                                $read_more.hide();
                            });
                        });
                    </script>
                @endPushAssets
            @else
                <span style="display: block; margin-bottom: 38px;word-break: break-word;">{{ $user->description->content ?? '' }}<br /></span>
            @endif
        </div>
    </div> 
</div>

