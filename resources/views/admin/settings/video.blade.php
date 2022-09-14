@extends('Admin::settings.form')

@section('settings.form_input')
    {{-- video.format --}}
    @component('Admin::common.form.group', ['key' => "{$group}.format", 'labelClasses' => 'es-required', 'labelId' => $group.'_name'])
        @slot('label')
            @lang('Video Format') <span class="text text-danger">*</span>
        @endslot

        @slot('input')
            <select name="{{ $group }}[format]" class="form-control" required="">
                @foreach(['mp4', 'wmv', 'mkv', 'mpg', 'avi'] as $format)
                    <option value="{{ $format }}" @if(isset($group['format']) && $group['format'] == $format) selected="" @endif>@lang($format)</option>
                @endforeach
            </select>
        @endslot
    @endcomponent
    {{-- end video.format--}}

    {{-- video.quality --}}
    @component('Admin::common.form.group', ['key' => "{$group}.quality", 'labelClasses' => 'es-required', 'labelId' => $group.'_name'])
        @slot('label')
            @lang('Video quality') <span class="text text-danger">*</span>
        @endslot

        @slot('input')
            <select name="{{ $group }}[quality]" class="form-control" required="">
                @foreach(['360p' => '360', '720p' => 720, '1080p' => 1080] as $name => $quality)
                    <option value="{{ $quality }}" @if(config("{$group}.quality") == $quality) selected="" @endif>@lang($name)</option>
                @endforeach
            </select>
        @endslot
    @endcomponent
    {{-- end video.quality--}}

    {{-- video.watermark--}}
    @component('Admin::common.form.group', ['key' => "{$group}.watermark", 'labelClasses' => 'es-required', 'labelId' => $group.'_name'])
        @slot('label')
            @lang('Watermark')
        @endslot

        @slot('input')
            @php
                $watermarkEnabled = false;
                $hasWatermark = false;
                $watermarkUrl = '';

                if (config("{$group}.watermark") !== null && config("{$group}.watermark") == 1) {
                    $watermarkEnabled = true;
                }

                if (config("{$group}.watermark_url") !== null) {
                    $hasWatermark = true;
                    $watermarkUrl = config("{$group}.watermark_url");
                }
            @endphp
            <input type="hidden" value="0" name="{{ $group }}[watermark]" />
            <input type="checkbox" name="{{ $group }}[watermark]" id="watermakrTrigger" @if($watermarkEnabled) checked="" @endif value="1" /> @lang('Apply Watermark')
            <div class="col-md-6" id="watermarkContainer" @if(!$watermarkEnabled) style="display:none" @endif>
                <img id="watermarkPreview" @if(is_array($watermark)) src="data:{{ $watermark['mime'] }};base64,{{ base64_encode($watermark['img']) }}" @else src="{{ $watermark }}" @endif width="100%" />
                <br />
                <br />
                <button type="submit" id="uploadWatermark" class="btn btn-sm btn-success">@lang('Upload')</button>
                <button type="button" id="removeWatermark" class="btn btn-sm btn-danger">@lang('Remove')</button>
            </div>
            <br />
            <br />
            <input type="hidden" class="form-control" id="{{ $group }}_watermark_url" name="{{ $group }}[watermark_url]" @if($hasWatermark) value="{{ $watermarkUrl }}" @endif />
            <input type="file" class="form-control" id="{{ $group }}_watermark" @if(!$watermarkEnabled) style="display:none" @endif />
        @endslot
    @endcomponent
    {{-- end video.watermark --}}
@endsection

@pushAssets('scripts.post')
<script type="text/javascript">
    $('input[type=checkbox]').on('change', function() {
        if(this.checked) {
            $('#watermarkContainer').show()
            $('#video_watermark').show()
        } else {
            $('#watermarkContainer').hide()
            $('#video_watermark').hide()
        }
    })

    $('#video_watermark').on('change', function() {
        if (this.files && this.files[0]) {
            var reader = new FileReader()

            reader.onload = function(e) {
                $('#watermarkPreview').attr('src', e.target.result)
            }

            reader.readAsDataURL(this.files[0])
        }
    })

    $('#uploadWatermark').on('click', function(e) {
        e.preventDefault()

        var formData = new FormData()
        formData.append('_token', "{{ csrf_token() }}")
        formData.append('video_watermark', $('#video_watermark')[0].files[0])

        $.ajax("{{ route('admin.settings.watermark') }}", {
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                var result = JSON.parse(data)
                notify('success', 'Watermark Uploaded', 2000)
                $('#video_watermark_url').val(result.path)
            },
            error: function(error) {
                console.log(error)
            }
        })
    })

    $('#removeWatermark').on('click', function(e) {
        e.preventDefault()
        $('#video_watermark').type = "text"
        $('#video_watermark').type = "file"
        $('#watermarkPreview').attr('src', 'https://via.placeholder.com/360x240.png?text=Placeholder')
    })
</script>
@endPushAssets