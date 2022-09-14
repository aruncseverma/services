<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#privatevideos">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Private Videos')</span>
        </div>
        <div class="card-header-sub">
            @lang('You can upload unlimitted number of private videos')
        </div>
        <div class="card-body collapse show" id="privatevideos">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row photos-folders" id="folders">
                        @foreach ($folders as $folder)
                            <div style="cursor: pointer;" class="col-3 @if ($folder->getKey() == $selectedFolder->getKey()) selected @endif" data-toggle="switch_folder" data-folder-id="{{ $folder->getKey() }}">
                                <i class="mdi mdi-folder"></i> {{ $folder->folderName() }}
                            </div>
                        @endforeach
                        <div class="col-3" style="cursor: pointer;" data-toggle="add_folder">
                            <i class="mdi mdi-folder-plus"></i> @lang('Add Folder')
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="photos-folders-selected">
                        @if ($selectedFolder)
                            <i class="mdi mdi-folder mdi-xs"></i>&nbsp;
                            <span id="elm_folder_name_container">
                                {{ $selectedFolder->folderName() }}
                            </span>
                            &nbsp;
                            <button type="submit" class="btn btn-outline-secondary btn-sm" data-toggle="rename_folder" data-folder-id="{{ $selectedFolder->getKey() }}"><span class="action-button text-uppercase">@lang('Rename')</span></button>
                            <button type="submit" class="btn btn-outline-secondary btn-sm hide" data-toggle="cancel_rename" data-prev-folder-name="{{ $selectedFolder->folderName() }}"><span class="action-button text-uppercase">@lang('Cancel')</span></button>
                            <button type="submit" class="btn btn-outline-secondary btn-sm" data-toggle="delete_folder" data-folder-id="{{ $selectedFolder->getKey() }}"><span class="action-button text-uppercase">@lang('Delete')</span></button>
                        @endif
                    </div>
                </div>
                
                <div class="col-sm-10" style="display:none">
                    <input type="file" name="privateVideoFile" id="privateVideoFile" class="form-control" />
                </div>
                <div id="draggable-private" class="row col-sm-12">
                    @if ($selectedFolder)
                        <input type="hidden" id="selectedFolder" value="{{ $selectedFolder->id }}" />
                        @foreach ($privateVideos as $video)
                        <div data-id="{{ $video->media_id }}" class="col-md-3 draggable-element-private" style="margin-bottom: 3px">
                            <div class="bottom-right">
                                <button data-video-id="{{ $video->media_id }}" class="btnDelete btn btn-sm btn-danger"><i class="fa fa-trash"></i> @lang('Remove')</button>
                            </div>
                            <img src="data:{{ $storage->disk('private_thumbnails')->mimeType($video->video->thumbnail) }};base64,{{ base64_encode($storage->disk('private_thumbnails')->get($video->video->thumbnail)) }}" 
                                width="100%"
                                class="mklbItem"
                                data-video-src="{{ route('common.video', ['id' => $video->media_id]) }}" />
                        </div>
                        @endforeach
                        <div class="col-md-3 card card-default">
                            <div id="privateUploader" class="card-body bg-default vcenter">
                                <center>
                                    <i id="privateIcon" class="fa fa-plus"></i><br />
                                    <span id="privateMessage">@lang('Add Video')</span><br />
                                    <span id="privateProgress"></span>
                                </center>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
