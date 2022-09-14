@extends('EscortAdmin::layout')

@section('main.content.title')
<i class="mdi mdi-account-multiple-outline"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
<div class="col-12">
    @include('EscortAdmin::common.notifications')
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#allreviews">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('All Bookings')</span>
            {{ $bookings->links('pagination::escort_admin.items_per_page') }}
        </div>
        <div class="card-header-sub">
            @lang('View and control your bookings')
        </div>
        <div class="card-body collapse show" id="allreviews">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="th-small text-uppercase">@lang('date')</th>
                            <th class="th-medium text-uppercase">@lang('name')</th>
                            <th class="th-medium text-uppercase">@lang('email')</th>
                            <th class="th-small text-uppercase">@lang('number')</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->created_at ?? '' }}</td>
                            <td>{{ $booking->firstname ?? '' }} {{ $booking->lastname ?? '' }}</td>
                            <td>{{ $booking->email ?? '' }}</td>
                            <td>{{ $booking->phone ?? '' }}</td>
                            <td class="td-icons">
                                <a data-toggle="collapse" data-target="#reply_list_{{ $booking->id }}">
                                    <i class="mdi mdi-magnify"></i>
                                </a>
                                <a data-toggle="collapse" data-target="#reply_form_{{ $booking->id }}" class="es es-focus" data-focus-id="reply_content_{{ $booking->getKey() }}">
                                    <i class=" mdi mdi-reply"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        @include('EscortAdmin::common.table.no_results', ['colspan' => 5])
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $bookings->links('pagination::escort_admin.pagination') }}
        </div>
    </div>
</div>

@endsection

@pushAssets('scripts.post')
<script>
    $(function() {
        $(".reply-list").on("shown.bs.collapse", function() {
            var $form = $(this).find('form');
            var $formData = $form.serialize();
            if ($formData != '') {
                fnAjax({
                    url: $form.attr('action'),
                    method: $form.attr('method'),
                    data: $form.serialize(),
                    success: function(data) {
                        if (typeof data.status !== 'undefined') {
                            if (data.status === 1) {
                                $form.find('.reply-ids').remove();
                            }
                        }
                    }
                });
            }
        });
    });
</script>
@endPushAssets