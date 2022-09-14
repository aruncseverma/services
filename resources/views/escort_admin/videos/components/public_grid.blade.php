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
            <div id="publicUploader" style="display:none">
                <div class="row">
                    <div class="col-sm-10">
                        <input type="file" name="videoFile" id="videoFile" class="form-control" />
                    </div>
                    <div class="col-sm-2">
                        <button id="uploadButton" type="submit" class="btn btn-success"><i class="fa fa-upload"></i> @lang('Upload')</button>
                    </div>
                </div>
            </div>
            <br />
            <div id="draggable-public" class="row">
                @foreach($public as $video)
                <div data-id="{{ $video->media_id }}" class="col-md-3 draggable-element" style="margin-bottom: 3px">
                    <div class="bottom-right">
                        <button data-video-id="{{ $video->media_id }}" class="btnDelete btn btn-sm btn-danger"><i class="fa fa-trash"></i> @lang('Remove')</button>
                    </div>
                    <img src="data:{{ $storage->disk('public_thumbnail')->mimeType($video->video->thumbnail) }};base64,{{ base64_encode($storage->disk('public_thumbnail')->get($video->video->thumbnail)) }}" 
                        width="100%"
                        class="mklbItem"
                        data-video-src="{{ route('common.video', ['id' => $video->media_id]) }}" />
                </div>
                @endforeach
                @if (count($public) < 4)
                <div class="col-md-3 card card-default">
                    <div id="uploader" class="card-body bg-default vcenter">
                        <center>
                            <i id="publicIcon" class="fa fa-plus"></i><br />
                            <span id="publicMessage">@lang('Add Video')</span><br />
                            <span id="publicProgress"></span>
                        </center>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
