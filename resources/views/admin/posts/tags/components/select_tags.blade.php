@php
$tagId = $id ?? 'tag_ids';
$tagName = $name ?? 'tag_ids[]';
$value = $value ?? [];
$canAdd = $add ?? false;
@endphp
<select style="width: 100%" name="{{ $tagName }}" id="{{ $tagId }}" class="form-control" multiple>
    @foreach ($tags as $tag)
    <option value="{{ $tag->getKey() }}" @if(in_array($tag->getKey(), $value)) selected @endif>{{ $tag->getDescription($langCode, true)->name }}</option>
    @endforeach
</select>

@pushAssets('scripts.post')
<script>
    $(document).ready(function() {
        var $tags = $('#{{ $tagId }}');

        var $canAdd = '{{ $canAdd }}';
        var $tagOptions = {};
        if ($canAdd) {
            $tagOptions = {
                tags: true,
                tokenSeparators: [',', ' '],
                createTag: function(params) {
                    //return false; // to dont display "no result found" but it cant select
                    //return null; // display "no result found"
                    return {
                        id: params.term + '_new_tag', // add postfix to be unique to do not select other option with id = "params.term"
                        text: params.term,
                        newTag: true // add additional parameters
                    }
                },
            };
        }

        $tags.select2($tagOptions);

        if ($canAdd) {
            var quickAddUrl = '{{ route("admin.posts.tags.quick_add") }}';
            $tags.on('select2:select', function(e) {
                console.log(e.params.data);

                if (e.params.data.newTag === true) {

                    var selectedData = $tags.select2('data');
                    var lastIndex = selectedData.length - 1;

                    fnAjax({
                        url: quickAddUrl,
                        method: 'POST',
                        data: {
                            _token: '{{csrf_token()}}',
                            name: e.params.data.text
                        },
                        success: function(data) {
                            // or var $newOption = $(e.target).find('option[value="' + e.params.data.id + '"]');
                            var $newOption = $tags.find('option[value="' + e.params.data.id + '"]');
                            if (data.status == 1) {
                                $newOption.val(data.data).attr("selected", true);
                                // get wrong result when replacing value of new option tag
                                // ex. create 1 tag then replace its value
                                // then add another tag, the previous tag added will remove
                                // to fix we need to reinitialized
                                $tags.select2('destroy').select2($tagOptions).trigger('change');
                            } else {
                                $newOption.remove();
                            }
                        },
                    });
                }
            });
        }
    });
</script>
@endPushAssets