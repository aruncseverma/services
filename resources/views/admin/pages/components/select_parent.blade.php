@php
$name = $name ?? 'parent_id';
$id = $id ?? 'parent_id';
$value = $value ?? '';
@endphp

<div class="input-group mb-3">
    <input type="text" id="page_text_{{ $id }}" class="form-control" placeholder="@lang('-- Root Level Page --')" aria-label="" aria-describedby="basic-addon2" readonly>
    <div class="input-group-append">
        <button class="btn btn-outline-secondary" type="button" id="btn_remove_page_{{ $id }}" style="display:none;"><span class="mdi mdi-window-close"></span></button>
        <button class="btn btn-outline-secondary" type="button" id="btn_open_page_list_{{ $id }}"><span class="mdi mdi-magnify"></span></button>
    </div>
</div>
<input type="hidden" id="{{ $id }}" name="{{ $name }}" value="{{ $value }}" />

<!-- Modal -->
<div class="modal fade" id="modal_page_list_{{ $id }}" tabindex="-1" role="dialog" aria-labelledby="modal_page_listTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_page_listTitle">Select Page</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="list-group" id="page_container_{{ $id }}">
                    <h3 class="text-center">No page found</h3>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="btn_select_page_{{ $id }}">Select</button>
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

    .sub-page {
        padding-left: 5px;
    }
</style>
@endPushAssets

@pushAssets('scripts.post')
<script>
    $(document).ready(function() {
        var except_id = '{{ $except_id ?? "" }}';
        var page_input = $('#{{ $id }}');
        var page_text = $('#page_text_{{ $id }}');
        var btn_open_page_list = $('#btn_open_page_list_{{ $id }}');
        var modal_page_list = $('#modal_page_list_{{ $id }}');
        var page_container = $('#page_container_{{ $id }}');
        var btn_select_page = $('#btn_select_page_{{ $id }}');
        var btn_remove_page = $('#btn_remove_page_{{ $id }}');

        btn_open_page_list.click(function() {
            var isOpen = btn_open_page_list.data('is_open');
            if (typeof isOpen === 'undefined' ||
                isOpen != true
            ) {
                getPages(null, false, function(html) {
                    if (html != '') {
                        page_container.html(html);
                    }
                    btn_open_page_list.data('is_open', true);
                    modal_page_list.modal('show');
                });
            } else {
                modal_page_list.modal('show');
                btn_open_page_list.data('is_open', true);
            }
        })

        modal_page_list.on('show.bs.modal', function(e) {
            //
        })

        if (page_input.val() != '') {
            fnAjax({
                url: '{{ route("admin.page.get_page") }}',
                data: {
                    id: page_input.val()
                },
                beforeSend: function() {
                    page_text.val('Loading...');
                },
                success: function(data) {
                    if (data.status == 0) {
                        fnAlert(data.message);
                    } else {
                        if (typeof data.data !== 'undefined') {
                            page_text.val(data.data);
                        }
                    }
                }
            });
            btn_remove_page.show();
        }

        function getPages(page_id, hide_option, cb) {
            fnAjax({
                url: '{{ route("admin.page.get_pages") }}',
                data: {
                    parent_id: page_id,
                    except_id: except_id,
                    is_multiple: '{{ $is_multiple ?? "0" }}',
                    hide_option: hide_option || 0,
                    current_id: page_input.val()
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

        page_container.on('click', '.get-sub', function() {
            event.preventDefault();
            var page = $(this);
            var page_id = page.data('page_id');
            var is_open = page.data('is_open');
            var hide_option = page.data('hide_option') || 0;
            var container = $('#page_id_' + page_id);
            if (typeof is_open === 'undefined') {
                getPages(page_id, hide_option, function(html) {
                    $('#page_id_' + page_id).html(html);
                    page.data('is_open', 1);
                });
            } else {
                if (is_open == 1) {
                    page.data('is_open', 0);
                    container.hide();
                } else {
                    page.data('is_open', 1);
                    container.show();
                }
            }
        })
        // .on('click', '.page_ids', function() {
        //     page_input.val($(this).val());
        // });
        btn_select_page.click(function() {
            var page_selected = $("input[name='page_id']:checked");
            if (page_selected.length) {
                var ids = [];
                var txts = [];
                page_selected.each(function() {
                    var elm = $(this);
                    if (elm.val() > 0) {
                        //page_input.val(elm.val());
                        //page_text.val(elm.data('text'));
                        ids.push(elm.val());
                        txts.push(elm.data('text'));
                    }
                });
                page_input.val(ids.join(','));
                page_text.val(txts.join(', '));
                btn_remove_page.show();
            }
            modal_page_list.modal('hide');
        })

        btn_remove_page.click(function() {
            page_input.val('');
            page_text.val('');
            btn_remove_page.hide();
        })
    });
</script>
@endPushAssets