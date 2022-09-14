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

                @if ($selectedFolder)
                    @foreach ($selectedFolder->videos as $video)
                        @include('EscortAdmin::videos.components.video_container', ['video' => $video, 'visibility' => 'private'])
                    @endforeach

                    {{-- empty --}}
                    @include('EscortAdmin::videos.components.video_container', ['video' => null, 'visibility' => 'private'])
                @endif
            </div>
        </div>
    </div>
</div>
