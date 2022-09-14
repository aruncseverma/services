@php
$deleteUrl = $deleteUrl ?? route('admin.post.delete_photo');
$has_grid=false;
@endphp

@component('Admin::posts.components.form.card_collapse', ['cardId' => 'featured_image'])
@slot('cardTitle')
@lang('Featured Image') 
@component('Admin::common.tooltip')
@slot('tooltipText')
<p>Featured image is used to represent your post</p>
<p>
    Featured images are more than just accessories for your website. Here are some benefits you’ll get by using them:<br>
    Attract visitors — displaying enticing images will pique visitors’ curiosity and encourage them to read your posts.<br>
    Increase the value of content — images help readers to understand your content better.<br>
    Set the website’s tone — combined with the website theme, you’ll get to define the tone of the site and determine how the audience perceives your brand.<br>
    Improve SEO — using the right keywords for the caption and alt text can boost your site’s SEO.<br>
</p>
@endslot
@endcomponent
@endslot
@slot('cardContent')
{{-- end notification --}}
@lang('Recommended 150x200')
<div class="form-group">
    <div class="">
        <input type="file" class="dropify" name="post_photo" id="elm_inpt_photo" data-default-file="{{ $post->featuredPhotoUrl }}" />
        @include('Admin::common.form.error', ['key' => 'post_photo'])
        @include('Admin::common.form.error', ['key' => 'post_id'])
        <label for="elm_inpt_photo" class="es-required-r es-image-r" data-error-after-label="true" style="display:none;">Featured Photo</label>
    </div>
</div>

{{-- alt text --}}
@component('Admin::common.form.group', ['has_grid' => $has_grid, 'key' => 'post_photo_data.alt_text', 'labelId' => 'post_photo_alt_text'])
@slot('label')
@lang('Alt text')
@endslot
@slot('input')
<input type="text" id="post_photo_alt_text" name="post_photo_data[alt_text]" class="form-control" value="{{ $post->featuredPhoto->data['alt_text'] ?? '' }}" />
@endslot
@endcomponent
{{-- end alt text --}}

{{-- caption --}}
@component('Admin::common.form.group', ['has_grid' => $has_grid, 'key' => 'post_photo_data.caption', 'labelId' => 'post_photo_caption'])
@slot('label')
@lang('Caption')
@endslot
@slot('input')
<textarea id="post_photo_caption" name="post_photo_data[caption]" class="form-control" style="resize: vertical;">{{ $post->featuredPhoto->data['caption'] ?? '' }}</textarea>
@endslot
@endcomponent
{{-- end caption --}}

@endslot
@endcomponent

@pushAssets('styles.post')
<link href="{{ asset('assets/theme/admin/default/plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet" />
@endPushAssets

@pushAssets('scripts.post')
<script src="{{ asset('assets/theme/admin/default/plugins/dropify/dist/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/js/growl.min.js') }}"></script>
<script type="text/javascript">
    //var btn_upload = $('#btn_upload')
    var input_photo = $('#elm_inpt_photo');
    // init dropify
    var drEvent = input_photo.dropify();

    var DELETE_PROFILE_PHOTO_ACTION_URL = '{{ $deleteUrl }}?id={{ $post->getKey() }}';
    // before dropify delete event
    drEvent.on('dropify.beforeClear', function() {
        if (input_photo.val() == '' && input_photo.data('default-file') != '') {
            swal({
                title: 'Delete?',
                text: 'Are you sure? All changes done cannot be reverted.',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: 'Yes',
            }, function() {
                setTimeout(function() {
                    var $form = $('<form></form>');
                    $form.attr('action', DELETE_PROFILE_PHOTO_ACTION_URL);
                    $form.attr('method', 'POST');
                    $form.append($('<input></input>').attr('name', '_token').val($('meta[name="csrf-token"]').attr('content')));
                    $('body').append($form);
                    $form.trigger('submit');
                }, 50);
            });
            return false;
        }
        return true;
    });

    drEvent.on('dropify.afterClear', function() {
        if (input_photo.data('default-file') != '') {
            input_photo.data('dropify').setPreview(true, input_photo.data('default-file'));
        }
    });
</script>
@endPushAssets