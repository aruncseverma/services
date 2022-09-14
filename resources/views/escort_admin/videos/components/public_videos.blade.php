<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#publicvideos">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Public Videos')</span>
        </div>
        <div class="card-header-sub">
            @lang('Upload maximum of 4 public videos')
        </div>
        <div class="card-body collapse show" id="publicvideos">
            <div class="row">
                @for ($i = 0; $i < $maxPublicVideos; $i++)
                    @php $video = $public->get($i); @endphp
                    @include('EscortAdmin::videos.components.video_container', ['video' => $video, 'visibility' => 'public'])
                @endfor
            </div>
        </div>
    </div>
</div>
