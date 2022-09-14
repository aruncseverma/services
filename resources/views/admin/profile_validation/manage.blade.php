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
                {{-- search --}}
                @component('Admin::common.search', ['action' => route('admin.profile_validation.manage')])
                    <input type="hidden" name="limit" value="{{ $search['limit'] }}">

                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="name">@lang('Escort Name')</label>
                                <input type="text" id="name" class="form-control" name="name" value="{{ $search['name'] }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="user_group_id">@lang('For Validation')</label>
                                <select name="user_group_id" id="user_group_id" class="form-control">
                                    <option value="*">@lang('All')</option>
                                    @foreach ($groups as $group)
                                        <option value="{{ $group->getKey() }}" @if ($group->getKey() == $search['user_group_id']) selected="" @endif>{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="status">@lang('Status')</label>
                                <div class="m-b-10">
                                    <label class="custom-control custom-radio">
                                        <input id="approved" name="status" type="radio" class="custom-control-input" @if ($search['status'] == 'approved') checked="" @endif value="approved">
                                        <span class="custom-control-label">@lang('Approved')</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input id="pending" name="status" type="radio" class="custom-control-input" @if ($search['status'] == 'pending') checked="" @endif value="pending">
                                        <span class="custom-control-label">@lang('Pending')</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input id="denied" name="status" type="radio" class="custom-control-input" @if ($search['status'] == 'denied') checked="" @endif value="denied">
                                        <span class="custom-control-label">@lang('Denied')</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input id="approved_all" name="status" type="radio" class="custom-control-input" @if ($search['status'] == '*') checked="" @endif value="*">
                                        <span class="custom-control-label">@lang('All')</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcomponent
                {{-- end search --}}

                {{-- notification --}}
                @include('Admin::common.notifications')
                {{-- end notification --}}

                @component('Admin::common.table')
                    @slot('head')
                        <th>@lang('Escort Name')</th>
                        <th>@lang('For Validation')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Date Requested')</td>
                        <th>@lang('Actions')</th>
                    @endslot

                     @slot('body')
                        @forelse ($requests as $request)
                            <tr>
                                <td>{{ $request->user->name }}</td>
                                <td>{{ $request->userGroup->name }}</td>
                                <td>
                                    @if ($request->isApproved())
                                        <label class="label label-success">@lang('Approved')</label>
                                    @elseif ($request->isDenied())
                                        <label class="label label-danger">@lang('Denied')</label>
                                    @else
                                        <label class="label label-warning">@lang('Pending')</label>
                                    @endif
                                </td>
                                <td>
                                    {{ $request->getAttribute($request->getCreatedAtColumn()) }}
                                </td>
                                <td>
                                    <button class="btn btn-info btn-xs" data-route="{{ route('admin.profile_validation.view', ['model' => $request->getKey()]) }}" data-toggle="modal" data-target="#elm_view_modal" title="@lang('Preview Requirements')">
                                        <i class="fa fa-search"></i>
                                    </button>

                                    {{-- pending --}}
                                    @if (! $request->isApproved() && ! $request->isDenied())
                                        <button class="btn btn-success btn-xs" data-route="{{ route('admin.profile_validation.approve', ['model' => $request->getKey()]) }}" data-toggle="request_change_status_approve" title="{{ __('Approved') }}">
                                            <i class="fa fa-check"></i>
                                        </button>

                                        <button class="btn btn-danger btn-xs" data-route="{{ route('admin.profile_validation.deny', ['model' => $request->getKey()]) }}" data-toggle="modal" data-target="#elm_denied_reason_modal" title="{{ __('Deny') }}">
                                            <i class="fa fa-times"></i>
                                        </button>
                                    @endif

                                    @include('Admin::common.table.actions.delete', ['to' => route('admin.profile_validation.delete', ['model' => $request->getKey()]), 'id' => $request->getKey()])
                                </td>
                            </tr>
                        @empty
                            @include('Admin::common.table.no_results', ['colspan' => 5])
                        @endforelse
                    @endslot
                @endcomponent

                {{ $requests->links() }}
            </div>
        </div>
    </div>

{{-- view modal --}}
<div class="modal fade" id="elm_view_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('View Requirements')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body" id="elm_modal_body">
                <i class="fa fa-circle-o-notch fa-spin"></i>
            </div>
        </div>
    </div>
</div>
{{-- end view modal --}}

{{-- deny form modal --}}
<div class="modal fade" id="elm_denied_reason_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Reason')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <form action="" method="POST" id="frm_reason" class="es es-validation">
                <div class="modal-body">

                    <div class="form-group">
                        <label for="reason" class="es-required">@lang('State your reason'):</label>
                        <textarea id="reason" name="reason" class="form-control"></textarea>
                    </div>

                    @csrf
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-info waves-effect" id="elm_deny_submit">@lang('Submit')</button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">@lang('Close')</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- end deny form modal --}}

@endsection

@pushAssets('scripts.post')
    <script type="text/javascript">
        $(function () {
            // modal body
            var $body = $('#elm_modal_body');

            // onload
            $('#elm_view_modal').on('shown.bs.modal', function(e) {
                var $btn = $(e.relatedTarget);
                var url = $btn.data('route');

                if (url !== 'undefined') {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        cache: false,
                        success: function (data) {
                            $body.html(data);
                        },
                        error: function (xhr) {
                            $body.html('Error while doing your request. Error Code: ' + xhr.status);
                        }
                    })
                }
            });

            // on close
            $('#elm_view_modal').on('hidden.bs.modal', function(e) {
                $body.html('<i class="fa fa-circle-o-notch fa-spin"></i>');
            });

            // approval action
            $('[data-toggle="request_change_status_approve"]').on('click', function (e) {
                e.preventDefault();

                var action = $(this).data('route');

                swal({
                    title: '@lang("Are you sure?")',
                    text: '@lang("Approving this validation cannot be undone. Please proceed with caution")',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "@lang('Yes')",
                    closeOnConfirm: true
                }, function () {
                    var $form  = $('<form></form>');

                    // set form attributes
                    $form.attr('action', action);
                    $form.attr('method', 'POST');

                    // append form csrf field
                    var $csrfField = $('<input></input>');

                    // set attributes
                    $csrfField.attr('name', '_token');
                    $csrfField.val($('meta[name="csrf-token"]').attr('content'));

                    // append csrf
                    $form.append($csrfField);

                    // append form to body
                    $(document.body).append($form);

                    // submit form
                    $form.submit();
                });
            });

            // onload modal
            $('#elm_denied_reason_modal').on('shown.bs.modal', function(e) {
                var $btn = $(e.relatedTarget);
                var action = $btn.data('route');
                if (action != 'undefined') {
                    $('#frm_reason').attr('action', action);
                }
            });

            // capture submit button action
            $('#elm_deny_submit').on('click', function (e) {
                swal({
                    title: '@lang("Are you sure?")',
                    text: '@lang("Denial this validation cannot be undone. Please proceed with caution")',
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "@lang('Yes')",
                    closeOnConfirm: true
                }, function () {
                    // submit form
                    $('#frm_reason').submit();
                });
                return false;
            });
        });
    </script>
@endPushAssets
