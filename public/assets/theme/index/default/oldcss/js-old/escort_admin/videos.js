/**
 * javascript for escort admin videos uploader
 *
 * @author Mike Alvarez
 */

const VISIBILITY_PUBLIC = 'public';
const VISIBILITY_PRIVATE = 'private';

// initial dropify
function init_events()
{
    // init dropify
    var drEvent = $('.dropify').dropify();

    drEvent.off('change');

    // upload
    drEvent.on('change', function (e) {
        var $target = $(e.currentTarget);
        var $wrapper = $target.parent();

        // checks if current file has error on it
        if ($wrapper.hasClass('has-error') === false && this.files.length == 1) {
            var video_id = $target.data('video-id');
            if ($target.data('visibility') == VISIBILITY_PRIVATE) {
                upload_file(PRIVATE_UPLOAD_URL, this.files[0], $('#privatevideos'), video_id, $target.data('folder-id'));
            } else {
                upload_file(PUBLIC_UPLOAD_URL, this.files[0], $('#publicvideos'), video_id);
            }
        }
    });

    // remove file
    drEvent.on('dropify.beforeClear', function (e) {
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

                if ($target.data('visibility') == VISIBILITY_PRIVATE) {
                    delete_file(PRIVATE_DELETE_URL, $('#privatevideos'), video_id);
                } else {
                    delete_file(PUBLIC_DELETE_URL, $('#publicvideos'), video_id);
                }
            }, 50);
        });
        return false;
    });

    // add folder
    $('[data-toggle="add_folder"]').off('click').on('click', function () {
        create_folder($('#privatevideos'));
    });

    // switch folder
    $('[data-toggle="switch_folder"]').off('click').on('click', function () {
        switch_folder($('#privatevideos'), $(this).data('folder-id'));
    });

    // rename folder
    $('[data-toggle="rename_folder"]').off('click').on('click', function () {
        // get element of the input for folder name
        var $elm_input = $('#elm_folder_name');

        if ($elm_input.length > 0) {
            // send rename action
            rename_folder($('#privatevideos'), $(this).data('folder-id'), $elm_input.val());
        } else {
            // replaces current html with the input
            var $text_container = $('#elm_folder_name_container');
            var prev_name = $text_container.text();
            var $input = $('<input></input>');
            var $cancel_btn = $('[data-toggle="cancel_rename"]');

            $input.addClass('form-control col-lg-3');
            $input.val(prev_name.trim());
            $input.attr('id', 'elm_folder_name');
            $text_container.html($input);

            // show cancel button and hide delete
            $cancel_btn.show();
            $('[data-toggle="delete_folder"]').hide();
        }
    });

    // cancel rename folder
    $('[data-toggle="cancel_rename"]').off('click').on('click', function () {
        var $input = $('#elm_folder_name');
        var $text_container = $('#elm_folder_name_container');

        // reshow text
        $text_container.html($(this).data('prev-folder-name'));

        // hide and show delete button and cancel
        $(this).hide();
        $('[data-toggle="delete_folder"]').show();
    });

    // delete a folder
    $('[data-toggle="delete_folder"]').off('click').on('click', function () {
        var $target = $(this);
        swal({
            title: 'Delete?',
            text: 'Are you sure? All changes done cannot be reverted.',
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: 'Yes',
        }, function () {
            setTimeout(function () {
                var folder_id = $target.data('folder-id');
                delete_folder($('#privatevideos'), folder_id);
            }, 50);
        });
    });
}

// upload a file
function upload_file(url, file, $container, video_id, folder_id)
{
    var video_id = video_id || null;
    var folder_id = folder_id || null;

    if (! url) {
        return false;
    }

    var fd = new FormData($('<form></form>').get(0));

    fd.append('video', file);

    // append folder_id
    if (folder_id) {
        fd.append('folder_id', folder_id);
    }

    // append video id
    if (video_id) {
        fd.append('id', video_id);
    }

    // call ajax to upload
    $.ajax({
        url: url,
        data: fd,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function (xhr) {
            $('#loader').show();
        },
        success: function (response) {
            var $elm = $(response).find('#' + $container.attr('id'));
            $container.html($elm.html());

            // alert
            swal({
                title: 'Success!',
                text: 'Video uploaded successfully',
                type: "info",
            });
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
                    text: 'Sorry we cannot currently process your request. Please try again later',
                    type: 'error',
                });
            } else if (xhr.status == 429) {
                swal({
                    title: 'Error!',
                    text: 'It seems that your file exceeds the maximum file size allowed by the server. Please select another one',
                    type: 'error',
                });
            } else if (xhr.status == 422) {
                swal({
                    title: 'Warning!',
                    text: body.errors.video[0],
                    type: 'warning',
                });
            } else if (xhr.status == 413) {
                swal({
                    title: 'Error!',
                    text: 'Video was too large to be handled by the server.',
                    type: 'error'
                });
            } else if (xhr.status == 400) {
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
}

// delete a file
function delete_file(url, $container, video_id)
{
    var video_id = video_id || null;

    if (! url) {
        return false;
    }

    var fd = new FormData($('<form></form>').get(0));

    // append inputs
    fd.append('id', video_id);

    // call
    $.ajax({
        url: url,
        data: fd,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function (xhr) {
            $('#loader').show();
        },
        success: function (response) {
            var $elm = $(response).find('#' + $container.attr('id'));
            $container.html($elm.html());

            // alert
            swal({
                title: 'Success!',
                text: 'Video deleted successfully',
                type: "info",
            });
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
}

// create folder
function create_folder($container)
{
    $.ajax({
        url: CREATE_FOLDER_URL,
        type: 'POST',
        beforeSend: function () {
            $('#loader').show();
        },
        success: function (response) {
            var $elm = $(response).find('#' + $container.attr('id'));
            $container.html($elm.html());
        },
        error: function (xhr) {
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
                    text: 'Sorry we cannot currently process your request. Please try again later',
                    type: 'error',
                });
            } else if (xhr.status == 429) {
                swal({
                    title: 'Error!',
                    text: 'It seems that your file exceeds the maximum file size allowed by the server. Please select another one',
                    type: 'error',
                });
            } else if (xhr.status == 422) {
                swal({
                    title: 'Warning!',
                    text: body.message,
                    type: 'warning',
                });
            } else if (xhr.status == 413) {
                swal({
                    title: 'Error!',
                    text: 'Video was too large to be handled by the server.',
                    type: 'error'
                });
            } else {
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
}

// switch folder
function switch_folder($container, folder_id)
{
    if (! folder_id) {
        return;
    }

    var fd = new FormData($('<form></form>').get(0));

    // append inputs
    fd.append('id', folder_id);

    $.ajax({
        url: SWITCH_FOLDER_URL,
        data: fd,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function (xhr) {
            $('#loader').show();
        },
        success: function (response) {
            var $elm = $(response).find('#' + $container.attr('id'));
            $container.html($elm.html());
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
                    text: 'Sorry we cannot currently process your request. Please try again later',
                    type: 'error',
                });
            } else if (xhr.status == 429) {
                swal({
                    title: 'Error!',
                    text: 'It seems that your file exceeds the maximum file size allowed by the server. Please select another one',
                    type: 'error',
                });
            } else if (xhr.status == 422) {
                swal({
                    title: 'Warning!',
                    text: body.message,
                    type: 'warning',
                });
            } else {
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
    });
}

// rename folder
function rename_folder($container, folder_id, folder_name)
{
    if (! folder_id || ! folder_name) {
        return false;
    }

    var fd = new FormData($('<form></form>').get(0));

    // append inputs
    fd.append('id', folder_id);
    fd.append('folder_name', folder_name);

    $.ajax({
        url: RENAME_FOLDER_URL,
        data: fd,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function (xhr) {
            $('#loader').show();
        },
        success: function (response) {
            var $elm = $(response).find('#' + $container.attr('id'));
            $container.html($elm.html());

            swal({
                title: 'Success!',
                text: 'Folder renamed successfully',
                type: 'success',
            })
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
                    text: 'Sorry we cannot currently process your request. Please try again later',
                    type: 'error',
                });
            } else if (xhr.status == 429) {
                swal({
                    title: 'Error!',
                    text: 'It seems that your file exceeds the maximum file size allowed by the server. Please select another one',
                    type: 'error',
                });
            } else if (xhr.status == 422) {
                swal({
                    title: 'Warning!',
                    text: body.message,
                    type: 'warning',
                });
            } else if (xhr.status == 413) {
                swal({
                    title: 'Error!',
                    text: 'Video was too large to be handled by the server.',
                    type: 'error'
                });
            } else {
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
    });
}

// delete folder
function delete_folder($container, folder_id)
{
    if (! folder_id) {
        return false;
    }

    var fd = new FormData($('<form></form>').get(0));

    // append inputs
    fd.append('id', folder_id);

    $.ajax({
        url: DELETE_FOLDER_URL,
        data: fd,
        type: 'POST',
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function (xhr) {
            $('#loader').show();
        },
        success: function (response) {
            var $elm = $(response).find('#' + $container.attr('id'));
            $container.html($elm.html());

            swal({
                title: 'Success!',
                text: 'Folder deleted successfully',
                type: 'success',
            })
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
                    text: 'Sorry we cannot currently process your request. Please try again later',
                    type: 'error',
                });
            } else if (xhr.status == 429) {
                swal({
                    title: 'Error!',
                    text: 'It seems that your file exceeds the maximum file size allowed by the server. Please select another one',
                    type: 'error',
                });
            } else if (xhr.status == 422) {
                swal({
                    title: 'Error!',
                    text: body.message,
                    type: 'error',
                    showConfirmButton: true,
                });
            } else if (xhr.status == 413) {
                swal({
                    title: 'Error!',
                    text: 'Video was too large to be handled by the server.',
                    type: 'error'
                });
            } else {
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
    });
}

// document ready
$(function() {
    init_events();
});
