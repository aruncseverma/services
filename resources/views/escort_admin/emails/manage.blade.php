@extends('EscortAdmin::layout')

@section('main.content.title')
<i class="mdi mdi-email"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
<div class="col-lg-2 col-md-4">
    <div class="card-body inbox-panel"><a href="{{ route('escort_admin.emails.compose') }}" class="btn btn-primary m-b-20 p-10 btn-block waves-effect waves-light">@lang('Compose')</a>
        <ul class="list-group list-group-full">
            <li class="list-group-item active"> <a href="{{ route('escort_admin.emails.manage') }}"><i class="mdi mdi-email"></i> @lang('Inbox') </a><span class="badge badge-success ml-auto">{{ $email_count }}</span></li>
        </ul>
    </div>
</div>
<div class="col-lg-10 col-md-8">
    <form method="POST" action="{{ route('escort_admin.emails.delete') }}">
        @csrf
        <div class="card-body text-right">
            <div class="btn-group m-b-10 m-r-10" role="group" aria-label="Button group with nested dropdown">
                <button type="submit" class="btn btn-secondary font-18 text-dark es es-confirm es-need-selected-items" data-need-selected-items-selector=".cb-email"><i class="mdi mdi-delete"></i></button>
                <a href="{{ route('escort_admin.emails.manage') }}" class="btn btn-secondary font-18 text-dark"><i class="mdi mdi-reload"></i></a>
            </div>
        </div>
        <div class="card-body p-t-0">
            @include('EscortAdmin::common.notifications')
            <div class="card b-all shadow-none">
                <div class="inbox-center b-all table-responsive">
                    <table class="table table-hover no-wrap">
                        <thead>
                            <tr>
                                <th>
                                    <div class="checkbox">
                                        <input type="checkbox" id="checkbox0" value="check">
                                        <label for="checkbox0"></label>
                                    </div>
                                </th>
                                <th></th>
                                <th>From</th>
                                <th>Subject</th>
                                <th class="text-center">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($emails as $email)
                            <tr data-href="{{ route('escort_admin.emails.view', $email->id) }}" class="row-email @if(!$email->isSeen()) unread @endif" style="cursor:pointer">
                                <td style="width:10px">
                                    <div class="checkbox">
                                        <input type="checkbox" name="cb_email[]" class="cb-email" id="checkbox{{ $email->id }}" value="{{ $email->id }}">
                                        <label for="checkbox{{ $email->id }}"></label>
                                    </div>
                                </td>
                                <td style="width:40px"><i class="star-email @if($email->isStarred()) fa fa-star @else fa fa-star-o @endif" data-id="{{ $email->id }}"></i></td>
                                <td class="row-email">{{ $email->sender->name }}</td>
                                <td class="max-texts row-email">{{ $email->title }}</td>
                                <td class="text-center row-email">{!! date('M d, Y', strtotime($email->created_at)) !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@pushAssets('scripts.post')
<script type="text/javascript">
    $(document).ready(function() {

        $('#checkbox0').on('change', function(e) {
            if (this.checked) {
                $('.cb-email').each(function() {
                    this.checked = true
                })
            } else {
                $('.cb-email').each(function() {
                    this.checked = false
                })
            }
        })

        $('td.row-email').on('click', function() {
            window.location = $(this).parent().data('href')
        })

        $('.star-email').on('click', function(e) {

            var emailId = $(this).data('id')
            var route = "{{ route('escort_admin.emails.star', ':id') }}"
            route = route.replace(':id', emailId)

            var item = $(this);

            $.ajax(route, {
                method: 'GET',
                processData: false,
                contentType: false,
                dataType: 'JSON',
                success: function(data) {

                    if (data.is_starred) {
                        $(item).removeClass('fa-star-o')
                        $(item).addClass('fa-star')
                    } else {
                        $(item).removeClass('fa-star')
                        $(item).addClass('fa-star-o')
                    }
                },
                error: function(e) {
                    console.log(e)
                }
            })
        })
    })
</script>
@endPushAssets