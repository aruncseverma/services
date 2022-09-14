@php
$name = $name ?? 'parent_id';
$id = $id ?? 'parent_id';
$value = $value ?? '';
@endphp

<div class="input-group mb-3">
    <input type="text" id="cat_text_{{ $id }}" class="form-control" placeholder="Category" aria-label="" aria-describedby="basic-addon2" readonly>
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" id="btn_remove_category_{{ $id }}" style="display:none;"><span class="mdi mdi-window-close"></span></button>
        <button class="btn btn-outline-secondary" type="button" id="btn_open_category_list_{{ $id }}"><span class="mdi mdi-magnify"></span></button>
    </div>
</div>
<input type="hidden" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}" />

<!-- Modal -->
<div class="modal fade" id="modal_category_list_{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="modal_category_listTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_category_listTitle">Select Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="list-group" id="category_container_{{ $id }}">
                    <h3 class="text-center">No category found</h3>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn_select_cat_{{ $id }}">Select</button>
            </div>
        </div>
    </div>
</div>

@pushAssets('styles.post')
<style>
    .list-group-item:first-child,
    .list-group-item:last-child {
        border-radius: 0;
        margin-bottom: -1px;
    }

    .sub-category {
        padding-left: 5px;
    }
</style>
@endPushAssets

@pushAssets('scripts.post')
<script>
    $(document).ready(function() {
        var except_id = '{{ $except_id ?? "" }}';
        var cat_input = $('#{{ $id }}');
        var cat_text = $('#cat_text_{{ $id }}');
        var btn_open_category_list = $('#btn_open_category_list_{{ $id }}');
        var modal_category_list = $('#modal_category_list_{{ $id }}');
        var category_container = $('#category_container_{{ $id }}');
        var btn_select_cat = $('#btn_select_cat_{{ $id }}');
        var btn_remove_category = $('#btn_remove_category_{{ $id }}');

        btn_open_category_list.click(function() {
            var isOpen = btn_open_category_list.data('is_open');
            if (typeof isOpen === 'undefined' ||
                isOpen != true
            ) {
                getCategories(null, false, function(html) {
                    if (html != '') {
                        category_container.html(html);
                    }
                    btn_open_category_list.data('is_open', true);
                    modal_category_list.modal('show');
                });
            } else {
                modal_category_list.modal('show');
                btn_open_category_list.data('is_open', true);
            }
        })

        modal_category_list.on('show.bs.modal', function(e) {
            //
        })

        if (cat_input.val() != '') {
            fnAjax({
                url: '{{ route("admin.posts.categories.get_category") }}',
                data: {
                    id: cat_input.val()
                },
                beforeSend: function() {
                    cat_text.val('Loading...');
                },
                success: function(data) {
                    if (typeof data.status == 0) {
                        fnAlert(data.message);
                    } else {
                        if (typeof data.data !== 'undefined') {
                            cat_text.val(data.data);
                        }
                    }
                }
            });
            btn_remove_category.show();
        }

        function getCategories(category_id, hide_option, cb) {
            fnAjax({
                url: '{{ route("admin.posts.categories.get_categories") }}',
                data: {
                    parent_id: category_id,
                    except_id: except_id,
                    is_multiple: '{{ $is_multiple ?? "0" }}',
                    hide_option: hide_option || 0,
                    current_id: cat_input.val()
                },
                success: function(data) {
                    if (typeof data.html !== 'undefined') {
                        if (typeof cb === 'function') {
                            cb(data.html);
                        }
                    }
                }
            });
        }

        category_container.on('click', '.get-sub', function() {
            event.preventDefault();
            var cat = $(this);
            var cat_id = cat.data('cat_id');
            var is_open = cat.data('is_open');
            var hide_option = cat.data('hide_option') || 0;
            var container = $('#cat_id_' + cat_id);
            if (typeof is_open === 'undefined') {
                getCategories(cat_id, hide_option, function(html) {
                    $('#cat_id_' + cat_id).html(html);
                    cat.data('is_open', 1);
                });
            } else {
                if (is_open == 1) {
                    cat.data('is_open', 0);
                    container.hide();
                } else {
                    cat.data('is_open', 1);
                    container.show();
                }
            }
        })
        // .on('click', '.category_ids', function() {
        //     cat_input.val($(this).val());
        // });
        btn_select_cat.click(function() {
            var cat_selected = $("input.category_ids:checked");
            if (cat_selected.length) {
                var ids = [];
                var txts = [];
                cat_selected.each(function() {
                    var elm = $(this);
                    if (elm.val() > 0) {
                        //cat_input.val(elm.val());
                        //cat_text.val(elm.data('text'));
                        ids.push(elm.val());
                        txts.push(elm.data('text'));
                    }
                });
                cat_input.val(ids.join(','));
                cat_text.val(txts.join(', '));
                btn_remove_category.show();
            }
            modal_category_list.modal('hide');
        })

        btn_remove_category.click(function() {
            cat_input.val('');
            cat_text.val('');
            btn_remove_category.hide();
        })
    });
</script>
@endPushAssets