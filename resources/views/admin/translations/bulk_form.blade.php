@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
{{ $title }}
@endsection
{{-- end title --}}

@section('main.content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            {{-- notification --}}
            @include('Admin::common.notifications')
            {{-- end notification --}}

            <form id="translation_form" class="form es es-validation" action="{{ route('admin.translation.m_save') }}" method="POST">
                {{-- hidden --}}
                {{ csrf_field() }}
                <input type="hidden" id="total_rows" value="{{ count($translations) }}" />
                {{-- end hidden --}}

                @component('Admin::common.table')
                @slot('head')
                <th>@lang('Group')</th>
                <th>@lang('Key')</th>
                <th>@lang('Text')</th>
                <th>@lang('Actions')</th>
                @endslot

                @slot('body')
                @forelse ($translations as $k => $trans)
                <tr id="clone_row">
                    <td>
                        <input data-name-postfix="[group]" data-id-postfix="_group" autocomplete="off" require2d id="trans_{{ $k }}_group" type="text" class="form-control translation_groups" name="trans[{{ $k }}][group]" value="{{ $trans['group'] ?? '' }}" />
                        <label data-id-postfix="_group" for="trans_{{ $k }}_group" class="es-required" style="display:none;">Group</label>
                        @include('Admin::common.form.error', ['key' => 'trans.' . $k . '.group'])
                    </td>
                    <td>
                        <input data-name-postfix="[key]" data-id-postfix="_key" required2 id="trans_{{ $k }}_key" type="text" class="form-control translation_keys" name="trans[{{ $k }}][key]" value="{{ $trans['key'] ?? '' }}" />
                        <label data-id-postfix="_key" for="trans_{{ $k }}_key" class="es-required" style="display:none;">Key</label>
                        @include('Admin::common.form.error', ['key' => 'trans.' . $k . '.key'])
                    </td>
                    <td>
                        @foreach($languages as $lang)
                        <label data-id-postfix="_text_{{ $lang->code }}" for="trans_{{ $k }}_text_{{ $lang->code }}" class="es-required" style="width: 100px;font-size:12px;display:block;">{{ $lang->name }}</label>
                        <textarea data-name-postfix="[text][{{ $lang->code }}]" data-id-postfix="_text_{{ $lang->code }}" required2 class="form-control " style="resize: vertical;" rows="1" id="trans_{{ $k }}_text_{{ $lang->code }}" name="trans[{{ $k }}][text][{{ $lang->code }}]">{{ $trans['text'][$lang->code] ?? '' }}</textarea>
                        <br />
                        @include('Admin::common.form.error', ['key' => 'trans.' . $k . '.text.' . $lang->code])
                        @endforeach
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-secondary btn-add-row"><i class="fa fa-plus"></i></button>
                        <button type="button" class="btn btn-sm btn-secondary btn-clone-row"><i class="fa fa-clone"></i></button>
                        <button type="button" class="btn btn-sm btn-danger btn-remove-row"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr id="clone_row">
                    <td>
                        <input data-name-postfix="[group]" data-id-postfix="_group" autocomplete="off" required2 id="trans_0_group" type="text" class="form-control translation_groups" name="trans[0][group]" />
                        <label data-id-postfix="_group" for="trans_0_group" class="es-required" style="display:none;">Group</label>
                    </td>
                    <td>
                        <input data-name-postfix="[key]" data-id-postfix="_key" required2 id="trans_0_key" type="text" class="form-control translation_keys" name="trans[0][key]" />
                        <label data-id-postfix="_key" for="trans_0_key" class="es-required" style="display:none;">Key</label>
                    </td>
                    <td>
                        @foreach($languages as $lang)
                        <label data-id-postfix="_text_{{ $lang->code }}" for="trans_0_text_{{ $lang->code }}" class="es-required" style="width: 100px;font-size:12px;display:block;">{{ $lang->name }}</label>
                        <textarea data-name-postfix="[text][{{ $lang->code }}]" data-id-postfix="_text_{{ $lang->code }}" required2 class="form-control  @if ($loop->first) text-paste @endif" @if ($loop->first) data-copy-text-target="[data-auto-text='0']" @else data-auto-text='0' @endif  style="resize: vertical;" rows="1" id="trans_0_text_{{ $lang->code }}" name="trans[0][text][{{ $lang->code }}]"></textarea>
                        <br />
                        @endforeach
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-secondary btn-add-row"><i class="fa fa-plus"></i></button>
                        <button type="button" class="btn btn-sm btn-secondary btn-clone-row"><i class="fa fa-clone"></i></button>
                        <button type="button" class="btn btn-sm btn-danger btn-remove-row"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                @endforelse
                @endslot
                @endcomponent

                <div class="form-actions pull-right">
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                    <a href="{{ route('admin.translations.manage') }}" class="btn btn-inverse">@lang('Cancel')</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@pushAssets('scripts.post')
<!-- Autocomplete -->
<script src="{{ asset('assets/theme/admin/default/plugins/bootstrap-autocomplete/bootstrap-autocomplete.min.js') }}"></script>

<script>
    $(function() {
        var $groupData = null;
        fnAjax({
            url: '{{ route("admin.translations.get_groups") }}',
            method: 'GET',
            success: function(data) {
                $groupData = data;
                var $group = $('.translation_groups').eq(0);
                $group.autoComplete({
                    resolver: 'custom',
                    events: {
                        search: function(qry, callback) {
                            var res = [];
                            if (qry != '') {
                                for (var i in data) {
                                    if (data[i].indexOf(qry) !== -1) {
                                        res.push(data[i]);
                                    }
                                }
                            } else {
                                res = data;
                            }


                            callback(res);
                        }
                    },
                    minLength: 0,

                });
                $group.focus(function() {
                    $group.autoComplete('show');
                })
            }
        });

        var $textPasteElems = $('.text-paste');
        if ($textPasteElems.length) {
            $textPasteElems.each(function(index, elm) {
                fnCopyText($(this));
            });
        }

        var $form = $('#translation_form');

        var $cloneRow = $('#clone_row');
        var $rowCount = $('#total_rows').val();
        if ($rowCount > 1) {
            --$rowCount;
        }
        $form.on('click', '.btn-add-row, .btn-clone-row', function() {
                $rowCount++;
                var $elm = $(this);
                var $row = $elm.closest('tr');
                //var $clone = $cloneRow.clone(false);
                var $clone = $row.clone(false);
                $row.after($clone);

                // show remove button
                $clone.find('.btn-remove-row').show();

                $fields = $clone.find('.form-control');

                // remove error messages
                $clone.find('.form-control-feedback.text-danger').remove();

                // clear value
                if ($elm.hasClass('btn-add-row')) {
                    $fields.val('');
                }

                // rename attribute names and ids
                // and set autocomplete in group field
                $fields.each(function(i, e) {
                    var elm2 = $(this);
                    var elm_name = elm2.attr('name');
                    //var elm_new_name = elm_name.replace('trans[0]', 'trans[' + $rowCount + ']');
                    var elm_new_name = 'trans[' + $rowCount + ']' + elm2.attr('data-name-postfix');
                    elm2.attr('name', elm_new_name);

                    // rename id
                    var elm_id = elm2.attr('id');
                    //var elm_new_id = elm_id.replace('trans_0', 'trans_' + $rowCount);
                    var elm_new_id = 'trans_' + $rowCount + elm2.attr('data-id-postfix');
                    elm2.attr('id', elm_new_id);

                    if (elm2.hasClass('translation_groups')) {
                        elm2.autoComplete({
                            resolver: 'custom',
                            events: {
                                search: function(qry, callback) {
                                    var res = [];
                                    if (qry != '') {
                                        for (var i in $groupData) {
                                            if ($groupData[i].indexOf(qry) !== -1) {
                                                res.push($groupData[i]);
                                            }
                                        }
                                    } else {
                                        res = $groupData;
                                    }


                                    callback(res);
                                }
                            },
                            minLength: 0,

                        }).focus(function() {
                            elm2.autoComplete('show');
                        })
                    }

                    if (elm2.hasClass('text-paste')) {
                        elm2.data('copy-text-target', "[data-auto-text='" + $rowCount + "']");
                        setTimeout(() => {
                            fnCopyText(elm2);
                        }, 500);
                    } else if (typeof elm2.attr('data-auto-text') !== 'undefined') {
                        elm2.attr('data-auto-text', $rowCount);
                    }
                })

                // rename labels for attribute
                $lbls = $clone.find('label.es-required');
                $lbls.each(function(i, e) {
                    var elm2 = $(this);
                    // rename for attr
                    var elm_for = elm2.attr('for');
                    //var elm_new_for = elm_for.replace('trans_0', 'trans_' + $rowCount);
                    var elm_new_for = 'trans_' + $rowCount + elm2.attr('data-id-postfix');
                    elm2.attr('for', elm_new_for);
                })
            })
            .on('click', '.btn-remove-row', function() {
                var $elm = $(this);
                var $status = $elm.data('status');
                if (typeof $status === 'undefined' || $status !== true) {
                    var $row = $elm.closest('tr');
                    $fields = $row.find('.form-control');
                    $fields.attr('disabled', true);
                    $elm.data('status', true);
                    // remove error messages
                    $row.find('.form-control-feedback.text-danger').remove();
                } else {
                    var $row = $elm.closest('tr');
                    $fields = $row.find('.form-control');
                    $fields.attr('disabled', false);
                    $elm.data('status', false);
                }
            });

        // auto focus on first field
        $('.translation_groups:first').focus();
        // hide first row remove button
        $('.btn-remove-row:first').hide();
    });
</script>
@endPushAssets