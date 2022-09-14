@php($has_grid = false)

@component('Admin::posts.components.form.card_collapse', ['cardId' => 'card_categories'])
@slot('cardTitle')
@lang('Categories') 
    @component('Admin::common.tooltip')
        @slot('tooltipText')
        <p>You can use categories to sort and group your blog posts into different sections. For example, a news website might have categories for their articles filed under News, Opinion, Weather, and Sports.</p>
        <p>Categories help visitors quickly know what topics your website is about and allows them to navigate your site faster.</p>
        @endslot
    @endcomponent
@endslot
@slot('cardContent')

@component('Admin::common.form.group', ['has_grid' => $has_grid, 'key' => 'post.category_ids', 'labelId' => 'category_ids'])
@slot('label')
@endslot

@slot('input')
@include('Admin::posts.categories.components.select_parent', [
'id' => 'category_ids',
'name' => 'post[category_ids]',
'value' => $post->category_ids,
'is_multiple' => true,
])
@endslot
@endcomponent

<div>
    <a href="{{ route('admin.posts.categories.create') }}" id="btn-new-category">@lang('Add New Category')</a>
    <div id="new_category_container" style="display:none;">
        <hr />
        @component('Admin::common.form.group', ['has_grid' => $has_grid, 'key' => 'category_name', 'labelClasses' => '', 'labelId' => 'category_name'])
        @slot('label')
        @lang('New Category Name')
        @endslot
        @slot('input')
        <input type="text" id="category_name" class="form-control" />
        @endslot
        @endcomponent

        @component('Admin::common.form.group', ['has_grid' => $has_grid, 'key' => 'post.category_ids', 'labelId' => 'category_ids'])
        @slot('label')
        @lang('Parent Category')
        @endslot

        @slot('input')
        @include('Admin::posts.categories.components.select_parent', [
        'id' => 'category_parent_id',
        'name' => '',
        'value' => '',
        'is_multiple' => false,
        ])
        @endslot
        @endcomponent

        <button type="button" class="btn btn-success btn-sm" id="btn-save-new-category">@lang('Add New Category')</button>
        <button type="button" class="btn btn-danger btn-sm" id="btn-cancel-new-category">@lang('Cancel')</button>
    </div>
</div>
@endslot
@endcomponent

@pushAssets('scripts.post')
<script>
    $(document).ready(function() {
        var quickAddUrl = '{{ route("admin.posts.categories.quick_add") }}';
        var $btnNewCategory = $('#btn-new-category');
        var $newCategoryContainer = $('#new_category_container');
        var $btnCancelCategory = $('#btn-cancel-new-category');
        var $btnSaveCategory = $('#btn-save-new-category');

        var $categoryName = $('#category_name');
        var $categoryParentId = $('#category_parent_id');
        var post_category = $('#btn_open_category_list_category_ids');
        var $selectParentCategoryRemoveBtn = $('#btn_remove_category_category_parent_id');
        $btnNewCategory.click(function() {
            event.preventDefault();
            $newCategoryContainer.show();
            $btnNewCategory.hide();
        })
        $btnCancelCategory.click(function() {
            $newCategoryContainer.hide();
            $btnNewCategory.show();
        });

        $btnSaveCategory.click(function() {
            fnAjax({
                url: quickAddUrl,
                method: 'POST',
                data: {
                    _token: '{{csrf_token()}}',
                    name: $categoryName.val(),
                    parent_id: $categoryParentId.val()
                },
                success: function(data) {
                    if (data.status == 1) {
                        fnAlert(data.message);
                        // to fetch new request
                        post_category.data('is_open', false);
                        // reset form
                        $selectParentCategoryRemoveBtn.trigger('click');
                        $categoryName.val('');
                        // hide form and show add link
                        $newCategoryContainer.hide();
                        $btnNewCategory.show();
                    } else {
                        if (data.data == 'category_name') {
                            $categoryName.focus();
                        } else if (data.data == 'parent_category') {
                            $('#cat_text_category_parent_id').focus();
                        }

                        fnAlert(data.message);
                    }
                },
            });
        });
    });
</script>
@endPushAssets