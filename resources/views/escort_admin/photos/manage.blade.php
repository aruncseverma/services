@extends('EscortAdmin::layout')

@pushAssets('styles.post')
<link href="{{ asset('assets/theme/admin/default/plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/theme/admin/default/plugins/cropper/cropper.min.css') }}" rel="stylesheet" />
@endPushAssets

@section('main.content.title')
    {{ $title }}
@endsection

@section('main.content')
    <div class="container-fluid">
        <div class="row">

            <!-- Public Photos -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header" data-toggle="collapse" data-target="#publicphotos">
                        <div class="card-actions">
                            <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
                        </div>
                        <span>Public Photos</span>
                    </div>
                    <div class="card-header-sub">
                        Upload maximum of 3 profile pictures and 1 mini photo
                    </div>
                    <div class="card-body collapse show" id="publicphotos">
                        <div class="row">
                            <div class="col-sm-6 col-md-3 m-b-10">
                                <input type="file" id="main-photo-1" class="dropify" data-allowed-file-extensions="png jpg jpeg bmp" @if(isset($photos['main-photo-1.jpg'])) data-id={{ $photos['main-photo-1.jpg']['id'] }} @endif data-default-file="@if (isset($photos['main-photo-1.jpg'])){{ $photos['main-photo-1.jpg']['url'] }}@endif" />
                                <br /><button type="submit" class="primary-change btn btn-block @if(isset($photos['main-photo-1.jpg']) && $photos['main-photo-1.jpg']['primary'])  {{ 'btn-outline-danger' }} @else {{ 'btn-outline-primary' }} @endif main-photo-1-button" id="change_primary" @if(isset($photos['main-photo-1.jpg'])) data-id={{ $photos['main-photo-1.jpg']['id'] }} @endif >@if(isset($photos['main-photo-1.jpg']) && $photos['main-photo-1.jpg']['primary'])  {{ 'Primary' }} @else {{ ' Set as Primary' }} @endif</button>
                            </div>
                            <div class="col-sm-6 col-md-3 m-b-10">
                                <input type="file" id="main-photo-2" class="dropify" data-allowed-file-extensions="png jpg jpeg bmp" @if(isset($photos['main-photo-2.jpg'])) data-id={{ $photos['main-photo-2.jpg']['id'] }} @endif data-default-file="@if (isset($photos['main-photo-2.jpg'])){{ $photos['main-photo-2.jpg']['url'] }}@endif"/>
                                <br /><button type="submit" class="primary-change btn btn-block @if(isset($photos['main-photo-2.jpg']) && $photos['main-photo-2.jpg']['primary'])  {{ 'btn-outline-danger' }} @else {{ 'btn-outline-primary' }} @endif main-photo-2-button" id="change_primary" @if(isset($photos['main-photo-2.jpg'])) data-id={{ $photos['main-photo-2.jpg']['id'] }} @endif >@if(isset($photos['main-photo-2.jpg']) && $photos['main-photo-2.jpg']['primary'])  {{ 'Primary' }} @else {{ ' Set as Primary' }} @endif</button>
                            </div>
                            <div class="col-sm-6 col-md-3 m-b-10">
                                <input type="file" id="main-photo-3" class="dropify" data-allowed-file-extensions="png jpg jpeg bmp" @if(isset($photos['main-photo-3.jpg'])) data-id={{ $photos['main-photo-3.jpg']['id'] }} @endif data-default-file="@if (isset($photos['main-photo-3.jpg'])){{ $photos['main-photo-3.jpg']['url'] }}@endif"/>
                                <br /><button type="submit" class="primary-change btn btn-block @if(isset($photos['main-photo-3.jpg']) && $photos['main-photo-3.jpg']['primary'])  {{ 'btn-outline-danger' }} @else {{ 'btn-outline-primary' }} @endif main-photo-3-button" id="change_primary" @if(isset($photos['main-photo-3.jpg'])) data-id={{ $photos['main-photo-3.jpg']['id'] }} @endif >@if(isset($photos['main-photo-3.jpg']) && $photos['main-photo-3.jpg']['primary'])  {{ 'Primary' }} @else {{ ' Set as Primary' }} @endif</button>
                            </div>
                            <div class="col-sm-6 col-md-3 m-b-10">
                                <input type="file" id="main-photo-small" class="dropify" data-allowed-file-extensions="png jpg jpeg bmp" @if(isset($photos['main-photo-small.jpg'])) data-id={{ $photos['main-photo-small.jpg']['id'] }} @endif data-default-file="@if(isset($photos['main-photo-small.jpg'])) {{ $photos['main-photo-small.jpg']['url'] }}@endif" />
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            <!-- Private Photos -->
            <div class="col-12" id="privatePhotoContainer">
                <div class="card">
                    <div class="card-header" data-toggle="collapse" data-target="#privatephotos">
                        <div class="card-actions">
                            <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
                        </div>
                        <span>Private Photos</span>
                    </div>
                    <div class="card-header-sub">
                        You can upload unlimitted number of private photos
                    </div>
                    <div class="card-body collapse show" id="privatephotos">
                        <div class="row">

                            <div class="col-sm-12">
                                <div class="row photos-folders" id="folderContainer">
                                    <div class="col-md-2 col-sm-4" id="addFolder" style="cursor: pointer">
                                        <i class="mdi mdi-folder-plus" id="addFolder"></i>
                                        Add Folder
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12" id="folderNameContainer" @if (count($folders) == 0)  {{ 'hidden' }} @endif >

                                <div class="photos-folders-selected" id="selectedFolder">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1"><i class="mdi mdi-folder"></i></span>
                                        </div>
                                        <input class="form-control col-sm-5" type="text" id="folderName" value="New Folder" />
                                        &nbsp;
                                        <button type="submit" class="btn btn-outline-secondary" id="folderRename"><span class="action-button">RENAME</span></button>
                                        &nbsp;
                                        <button type="submit" class="btn btn-outline-secondary" id="folderDelete"><span class="action-button">DELETE</span></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="row" id="myImages">
                                    <div class="col-sm-6 col-md-3 m-b-10" id="privateImageContainer">
                                        <input type="file" id="uploader" class="dropify" />
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- Cropping Photos -->
            <div id="imageCropper" class="col-12">
                <div class="card">
                    <div class="card-header" data-toggle="collapse" data-target="#photocrop">
                        <div class="card-actions">
                            <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
                        </div>
                        <span>Crop Image</span>
                    </div>
                    <div class="card-header-sub">
                        Crop your image accordingly
                    </div>
                    <div class="card-body collapse show" id="photocrop">
                        <div class="row">
                            <!-- .Your image -->
                            <div class="col-12 m-b-20">
                                <center>
                                <div class="img-container" style="width:{{ config('image.max_width') }}px;height:{{ config('image.max_height') }}px">
                                    <img id="image" class="img-responsive" alt="Picture" data-min-crop-width="{{ config('image.min_width') }}" data-min-crop-height="{{ config('image.min_height') }}" >
                                </div>
                                </center>
                            </div>
                        </div>
                        <button id="uploadImage" type="submit" class="btn btn-outline-danger waves-effect waves-light button-save" data-method="getCroppedCanvas">CROP IMAGE</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@pushAssets('scripts.post')
<script src="{{ asset('assets/theme/admin/default/plugins/dropify/dist/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/cropper/cropper-init.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/cropper/cropper.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/js/growl.min.js') }}"></script>

@include('EscortAdmin::photos.scripts')

@endPushAssets
