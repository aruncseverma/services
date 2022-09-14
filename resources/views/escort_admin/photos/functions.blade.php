<script type="text/javascript">

function getAllPrivatePhotos() {
    notify('','','');
    $.ajax("{{ route('escort_admin.photos.folder') }}", {
        method: "GET",
        processData: false,
        contentType: false,
        success: function(data) {
            $('#folderName').val('')

            $('#folderNameContainer').hide()
            $('#myImages').hide()

            displayPrivateFolders(data)
        },
        error: function() {
            console.log("Error")
        }
    })
}

function displayPrivateFolders(data) {

    var result = ''

    $.each(data, function(key, value) {

        if (key == 0 && localStorage.getItem('active_folder') == null)
            displaySelectedFolder(value['id'], value['name'])

        if (localStorage.getItem('active_folder') == value['id']) {
            displaySelectedFolder(value['id'], value['name'])
        }


        var folderName = "'" + value['name'].replace("'", "\\'") + "'"
        
        if (localStorage.getItem('active_folder') == value['id'])
            result += '<div class="col-md-2 col-sm-4" id="viewFolder" data-id="' + value['id'] + '" style="cursor: pointer" onclick="displaySelectedFolder('+ value['id'] + ', '+ folderName + ')">'
                    + '<i class="mdi mdi-folder text-danger" data-id="' + value['id'] + '"></i><span class="restrain-text text-danger" data-id="' + value['id'] + '">'
                    + value['name']
                    + '</span></div>'
        else
            result += '<div class="col-md-2 col-sm-4" id="viewFolder" data-id="' + value['id'] + '" style="cursor: pointer" onclick="displaySelectedFolder('+ value['id'] + ', '+ folderName + ')">'
                        + '<i class="mdi mdi-folder" data-id="' + value['id'] + '"></i><span class="restrain-text" data-id="' + value['id'] + '">'
                        + value['name']
                        + '</span></div>'
    })

    if (result != '') {
        $('#folderNameContainer').show()
        $('#myImages').show()
    }

    $('#folderContainer').find('*').not('#addFolder').remove()
    $('#folderContainer').prepend(result)
}

function displaySelectedFolder(id, folder) {

    // Make the folder as selected
    localStorage.setItem('active_folder', id)

    // Change the name of the input box
    $('#folderName').val(folder)

    var url = '{{ route("escort_admin.photos.folder.view", ":id") }}'
    url = url.replace(":id", id)

    $.ajax(url, {
        method: 'GET',
        processData: false,
        contentType: false,
        success: function(data) {
            // Get all the photos uploaded for the selected folder
            displayPrivatePhotos(data.data.photos)
            resetFoldersState(id)
        },
        error: function(e) {
            console.log(e)
        }
    })
}

function displayPrivatePhotos(photos) {
    
    var save = $('#privateImageContainer').detach()
    $('#myImages').empty().append(save)

    if (photos.length > 0) {
        
        var privatePhotos = ''
        var count = 0
        var images = []

        $.each(photos, function(key, value) {
            privatePhotos += '<div class="col-sm-6 col-md-3 m-b-10">'
                            + '<input type="file" class="dropify private-photo" id="privateImage" data-allowed-file-extensions="png jpg jpeg bmp" data-id="' + value['id'] + '"  data-default-file="' + value['path'] + '" />'
                            + '</div>'

            images[count] = value['path']
            count++
        })
        
        $('#myImages').prepend(privatePhotos)
        $('.dropify').dropify()
    }
}

function resetPrimaryButtonsState(buttonInformation) {

    var imageId = $(buttonInformation).data('id')
    
    $('.primary-change').each(function(index, item) {
        $(item).removeClass('btn-outline-danger')
        $(item).addClass('btn-outline-primary')
        $(item).html('Set as Primary')

        if (imageId != null && imageId == $(item).data('id')) {
            $(item).removeClass('btn-outline-primary')
            $(item).addClass('btn-outline-danger')
            $(item).html('Primary')
        }
    })
}

function resetFoldersState(id) {
    
    $('.mdi-folder').each(function(index, item) {

        if (id != $(item).data('id'))
            $(item).removeClass('text-danger')
        else
            $(item).addClass('text-danger')
    })

    $('.restrain-text').each(function(index, item) {
        if (id != $(item).data('id'))
            $(item).removeClass('text-danger')
        else
            $(item).addClass('text-danger')
    })
}

function notify(type, message, timeout) {
    
    $.bootstrapGrowl(message, {
        type: type,
        allow_dismiss: false
    })
}
</script>
