@extends('EscortAdmin::layout')

@pushAssets('styles.post')
    <link href="{{ asset('assets/theme/admin/default/plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet" />
    <style>
        /* Bottom right text */
        .bottom-right {
            position: absolute;
            bottom: 8px;
            right: 25px;
        }
        .vcenter {
            display: inline-block;
            vertical-align: middle;
            float: none;
            cursor: pointer;
        }
        .vcenter:hover {
            background-color: azure;
        }
    </style>
@endPushAssets

@section('main.content.title')
    <i class="mdi mdi-video"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
    {{-- public --}}
    @include('EscortAdmin::videos.components.public_grid')
    {{-- end public --}}

    {{-- private --}}
    @include('EscortAdmin::videos.components.private_grid')
    {{-- end private --}}
@endsection

@pushAssets('scripts.post')
    <script src="{{ asset('assets/theme/admin/default/plugins/dropify/dist/js/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/theme/admin/default/plugins/sortable-animation/jquery.ui.sortable-animation.js') }}"></script>
    <script src="{{ asset('assets/theme/admin/default/js/growl.min.js') }}"></script>
    <script type="text/javascript">
        // init constants here
        const PUBLIC_UPLOAD_URL = '{{ route("escort_admin.videos.upload_public_video") }}';
        const PRIVATE_UPLOAD_URL = '{{ route("escort_admin.videos.upload_private_video") }}';
        const PUBLIC_DELETE_URL = '{{ route("escort_admin.videos.delete_public_video") }}';
        const PRIVATE_DELETE_URL = '{{ route("escort_admin.videos.delete_private_video") }}';
        const CREATE_FOLDER_URL = '{{ route("escort_admin.videos.private_create_folder") }}';
        const SWITCH_FOLDER_URL = '{{ route("escort_admin.videos.private_switch_folder") }}';
        const RENAME_FOLDER_URL = '{{ route("escort_admin.videos.private_rename_folder") }}';
        const DELETE_FOLDER_URL = '{{ route("escort_admin.videos.private_delete_folder") }}';
    </script>
    <script src="{{ asset('assets/theme/admin/default/js/escort_admin/videos.js') }}"></script>

    <script type="text/javascript">

        $(function() {

            $('#uploadProgress').hide()
            $('#renderProgress').hide()

            $('#uploader').on('click', function() {
                $('#videoFile').click()
            })

            $('#privateUploader').on('click', function() {
                $('#privateVideoFile').click()
            })

            $('#draggable-public').sortable({
                update: function(event, ui) {

                    var element = $('.draggable-element')
                    var positions = []

                    $.each(element, function(index, div) {
                        positions.push($(this).attr('data-id'))
                    })

                    var formData = new FormData()
                    formData.append('folder_id', 0)
                    formData.append('video_arrangement', positions)

                    var updatePath = "{{ route('escort_admin.videos.position') }}"

                    $.ajax(updatePath, {
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {

                        },
                        error: function(error) {

                        }
                    })
                }
            })

            $('#draggable-private').sortable({
                update: function(event, ui) {

                    var element = $('.draggable-element-private')
                    var positions = []

                    $.each(element, function(index, div) {
                        positions.push($(this).attr('data-id'))
                    })

                    var formData = new FormData()
                    formData.append('folder_id', $('#selectedFolder').val())
                    formData.append('video_arrangement', positions)

                    var updatePath = "{{ route('escort_admin.videos.position') }}"

                    $.ajax(updatePath, {
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {

                        },
                        error: function(error) {

                        }
                    })
                }
            })

            $('#videoFile').on('change', function(e) {
                e.preventDefault()

                var uploadPath = "{{ route('escort_admin.videos.upload_new_public_video') }}"

                var formData = new FormData()
                formData.append('_token', "{{ csrf_token() }}")
                formData.append('video', $('#videoFile')[0].files[0])

                $.ajax(uploadPath, {
                    method: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#uploadProgress').show()
                    },
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest()

                        xhr.upload.addEventListener('progress', function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total
                                percentComplete = parseInt(percentComplete * 100)
                                $('#publicMessage').html('Uploading file')
                                $('#publicIcon').prop('class', 'fa fa-spinner fa-spin')
                                $('#publicProgress').html(percentComplete + '%')

                                if (percentComplete >= 100) {
                                    $('#publicMessage').html('Rendering file')
                                    $('#publicIcon').prop('class', 'fa fa-cog fa-spin')
                                    $('#publicProgress').html('0%')
                                }
                            }
                        }, false)

                        return xhr
                    },
                    success: function(data) {
                        location.reload()
                    },
                    error: function(error) {
                        $('#publicIcon').prop('class', 'fa fa-cancel')
                        $('#publicMessage').html('Error Occured!')
                        $('#publicMessage').prop('class', 'bg-danger')
                    }
                })
            })
        })

        $('#privateVideoFile').on('change', function(e) {
            e.preventDefault()

            var uploadPath = "{{ route('escort_admin.videos.upload_new_private_video') }}"

            var formData = new FormData()
            formData.append('_token', "{{ csrf_token() }}")
            formData.append('folder_id', $('#selectedFolder').val())
            formData.append('video', $('#privateVideoFile')[0].files[0])

            $.ajax(uploadPath, {
                method: 'POST',
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                xhr: function() {
                    var xhr = new window.XMLHttpRequest()

                    xhr.upload.addEventListener('progress', function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total
                            percentComplete = parseInt(percentComplete * 100)
                            $('#privateMessage').html('Uploading file')
                            $('#privateIcon').prop('class', 'fa fa-spinner fa-spin')
                            $('#privateProgress').html(percentComplete + '%')

                            if (percentComplete >= 100) {
                                $('#privateMessage').html('Rendering file')
                                $('#privateIcon').prop('class', 'fa fa-cog fa-spin')
                                $('#privateProgress').html('0%')
                            }
                        }
                    }, false)

                    return xhr
                },
                success: function(data) {
                    location.reload()
                },
                error: function(error) {
                    $('#privateIcon').prop('class', 'fa fa-cancel')
                    $('#privateMessage').html('Error Occured!')
                    $('#privateMessage').prop('class', 'bg-danger')
                }
            })
        })

        // remove file
        $('.btnDelete').on('click', function (e) {
            e.preventDefault()
            var $target = $(e.currentTarget);
            swal({
                title: 'Delete?',
                text: 'Are you sure? All changes done cannot be reverted.',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: 'Yes',
            }, function () {
                setTimeout(function () {
                    var video_id = $target.data('video-id');

                    var fd = new FormData($('<form></form>').get(0));

                    // append inputs
                    fd.append('id', video_id);

                    // call
                    $.ajax({
                        url: PUBLIC_DELETE_URL,
                        data: fd,
                        type: 'POST',
                        cache: false,
                        processData: false,
                        contentType: false,
                        beforeSend: function (xhr) {
                            $('#loader').show();
                        },
                        success: function (response) {
                            // alert
                            swal({
                                title: 'Success!',
                                text: 'Video deleted successfully',
                                type: "info",
                            });

                            location.reload()
                        },
                        error: function (xhr, textStatus, thrownError) {
                            var body = xhr.responseJSON;
                            if (xhr.status == 500) {
                                swal({
                                    title: 'Error!',
                                    text: 'Ooops! something went wrong. Error Code: ' + xhr.status,
                                    type: 'error',
                                });
                            } else if (xhr.status == 503) {
                                swal({
                                    title: 'Error!',
                                    text: body.message || 'Sorry we cannot currently process your request. Please try again later',
                                    type: 'error',
                                });
                            } else if (xhr.status == 400 || xhr.status == 401) {
                                swal({
                                    title: 'Error!',
                                    text: body.message,
                                    type: 'error'
                                });
                            }
                        },
                        complete: function () {
                            $('#loader').hide();
                            // reset dropify
                            init_events();
                        },
                    })
                }, 50);
            });
            return false;
        });
    </script>
@endPushAssets
