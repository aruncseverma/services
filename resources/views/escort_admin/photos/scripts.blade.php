@include('EscortAdmin::photos.functions')

<script type="text/javascript">
    $(document).ready(function() {

        localStorage.clear()

        var currentItem
        var currentItemId
        var activeFolder = 0
        var folderInfo = {}

        getAllPrivatePhotos()

        // hide cropping tool
        $('#imageCropper').hide()
        $('#myImages').hide()

        radioswitch.init()

        // Basic
        var drEvent = $('.dropify').dropify()

        // Translated
        $('.dropify-fr').dropify({
            messages: {
                default: 'Glissez-déposez un fichier ici ou cliquez',
                replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                remove: 'Supprimer',
                error: 'Désolé, le fichier trop volumineux'
            }
        })

        var clear = function(event, element) {
            var $elem = $(this);
            var $status = $elem.data('clear-status');
            if (typeof $status === 'undefined') {
                fnConfirm({
                    title: "Delete?",
                    text: "Do you really want to delete \"" + element.file.name + "\" ?"
                }, function() {
                    var image_id = $elem.attr('data-id')

                    var formData = new FormData()
                    formData.append('image_id', image_id)
                    formData.append('_token', "{{ csrf_token() }}")

                    $.ajax("{{ route('escort_admin.photos.remove') }}", {
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(data) {

                            resetPrimaryButtonsState()
                            notify('success', 'Photo Deleted.', 2000)

                            if (localStorage.getItem('active_folder') != 'M')
                                getAllPrivatePhotos()
                            $elem.data('clear-status', true);
                            return $elem.next('.dropify-clear')[0].click();
                        },
                        error: function() {
                            notify('danger', 'Error encounter while deleting photo', 2000)
                            return false
                        }
                    })

                });
                return false;
            }
            $elem.removeData('clear-status');
            return true;
        }

        var change = function() {

            currentItem = this.id
            currentItemId = $(this).data('id')
            localStorage.setItem('current_selected_item', currentItem)

            if (currentItem.indexOf('main') != -1)
                localStorage.setItem('active_folder', 'M')


            if (this.files && this.files[0]) {
                var reader = new FileReader()

                reader.onload = function(e) {

                    var $target = $('#image')

                    // Destroy the old cropper instance
                    $target.cropper('destroy')

                    // Replace url
                    $target.attr('src', e.target.result)

                    // Start cropper
                    $target.cropper({
                        movable: false,
                        zoomable: false,
                        rotatable: false,
                        scalable: false,
                        minCropBoxWidth: $target.data('min-crop-width'),
                        minCropBoxHeight: $target.data('min-crop-height'),
                        cropBoxResizable: true,
                        crop: function(e) {
                            $target.val(e.x + ", " + e.y + "," + e.width + "," + e.height)
                        }
                    })

                }

                reader.readAsDataURL(this.files[0])
            }

            $('#imageCropper').show()
            $('#uploadImage').focus()
        }

        drEvent.on('dropify.beforeClear', clear)
        $("#myImages").delegate(".dropify", 'dropify.beforeClear', clear)
        $('#myImages').delegate('.dropify', 'change', change)

        drEvent.on('dropify.errors', function(event, element) {
            console.log('Has Errors')
        })

        // Delete Folder Function
        $('#folderDelete').on('click', function(e) {
            var currentFolder = localStorage.getItem("active_folder")

            fnConfirm({
                    title: "Delete?",
                    text: 'Are you sure you want to delete this Folder?'
            }, function() {

                var url = "{{ route('escort_admin.photos.folder.delete', ':id') }}"
                url = url.replace(':id', currentFolder)

                $.ajax(url, {
                    method: "GET",
                    processData: false,
                    contentType: false,
                    success: function(data) {

                        if (data == 1)
                            localStorage.clear()

                        notify('success', 'Folder removed.', 2000)
                        getAllPrivatePhotos()
                    },
                    error: function(e) {
                        getAllPrivatePhotos()
                    }
                })
            });
        })

        // Folder Rename Function
        $('#folderRename').on('click', function(e) {
            e.preventDefault()

            var folderName = $('#folderName').val()

            var formData = new FormData()
            formData.append('folder_id', localStorage.getItem('active_folder'))
            formData.append('new_name', folderName)
            formData.append('_token', "{{ csrf_token() }}")

            $.ajax("{{ route('escort_admin.photos.folder.rename') }}", {
                method: 'POST',
                data: formData,
                datType: 'json',
                processData: false,
                contentType: false,
                success: function(data) {
                    notify('success', 'Folder renamed.', 2000)
                    $('#folderName').val(data['folder_name'])
                    getAllPrivatePhotos()
                },
                error: function(error) {
                    console.log(error)
                }
            })
        })

        $('.dropify').change(change)

        // Handles adding folders
        $('#addFolder').on('click', function(e) {
            e.preventDefault()

            var formData = new FormData()
            formData.append('_token', "{{ csrf_token() }}")

            $.ajax("{{ route('escort_admin.photos.folder.create') }}", {
                method: "POST",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                success: function(data) {
                    getAllPrivatePhotos()

                    $('#folderNameContainer').removeAttr('hidden')
                    $('#privateImageContainer').removeAttr('hidden')
                },
                error: function(e) {
                    console.log(e)
                }
            })
        })

        // Handles switching primary photo
        $('.primary-change').on('click', function(e) {

            e.preventDefault()

            var $photo_id = $(this).data('id')

            // do not continue if photo is undefined
            if (!$photo_id) {
                return false;
            }

            var button = $(this)

            var api = "{{ route('escort_admin.photos.primary', ':id') }}"
            api = api.replace(':id', $photo_id)

            if ($photo_id != '' || $photo_id !== undefined)
                $.ajax(api, {
                    method: "GET",
                    processData: false,
                    contentTyoe: false,
                    success: function(data) {
                        if (data == 1)
                            resetPrimaryButtonsState(button)
                    },
                    error: function(e) {

                    }
                })
        })

        // Handles image uploading
        $('#uploadImage').on('click', function(e) {
            e.preventDefault()

            var $image = $('#image')
            var destinationFolder = localStorage.getItem('active_folder')

            var cropcanvas = $image.cropper('getCroppedCanvas')
            var croppng = cropcanvas.toDataURL("image/png")

            var formData = new FormData()

            if (currentItemId != null)
                formData.append('image_id', currentItemId)

            formData.append('file', croppng)
            formData.append('filename', currentItem)
            formData.append('_token', "{{ csrf_token() }}")
            formData.append('destination_folder', destinationFolder)

            // notify('info', 'Uploading image.', 2000)

            $.ajax("{{ route('escort_admin.photos.upload') }}", {
                method: "POST",
                data: formData,
                dataType: 'json',
                cache: false,
                processData: false,
                contentType: false,
                success: function (e) {
                    
                    if (e['result']) {
                        notify('success', 'Upload complete.', 2000)
                    
                        if (destinationFolder == 'M') {

                            $('#' + currentItem).attr('data-id', e['id'])
                            $('.' + currentItem + '-button').attr('data-id', e['id'])

                            var filedropper = $('#' + currentItem).dropify()
                            filedropper = filedropper.data('dropify')
                            filedropper.resetPreview()
                            filedropper.settings['defaultFile'] = e['url']
                            filedropper.destroy()
                            filedropper.init()

                        } else {

                            var filedropper = $('#' + currentItem).dropify()
                            filedropper = filedropper.data('dropify')
                            filedropper.resetPreview()
                            filedropper.destroy()
                            filedropper.init()

                            getAllPrivatePhotos()
                        }

                        $('#imageCropper').hide()
                        $('#imageCropper').blur()
                        $('#privatePhotoContainer').show(500)
                    } else {
                        notify('danger', e['error'], 2000)
                    }
                },
                error: function() {
                    notify('danger', 'Upload error.', 2000)
                    console.log('Upload error')
                }
            })
        })

        var drDestroy = $('#input-file-to-destroy').dropify()
        drDestroy = drDestroy.data('dropify')
        $('#toggleDropify').on('click', function(e) {
            e.preventDefault()
            if (drDestroy.isDropified()) {
                drDestroy.destroy()
            } else {
                drDestroy.init()
            }
        })
    })
</script>