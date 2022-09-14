<div class="col-sm-6 col-md-3 m-b-10">
    <input type="file" id="input-file-now-custom-1" class="dropify" data-video-id="{{ optional($video)->getKey() }}" @isset($folder) data-folder-id="{{ $folder->getKey() }}" @endisset data-visibility="{{ $visibility }}" data-default-file="{{ optional($video)->path }}" data-allowed-file-extensions="{{ implode(' ', $allowedExts) }}"/>
    @if ($video)
        @include('EscortAdmin::videos.components.watch_video', ['video' => $video])
    @endif
</div>
