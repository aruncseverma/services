@extends('EscortAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-format-quote"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
<div class="col-12">
    @include('EscortAdmin::common.notifications')
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#allfollowers">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Followers')</span>
            <div class="pull-right currency-drop">
                <select class="selectpicker" data-style="btn-info" id="btn-actions">
                    <option value="select_action" style="display:none">@lang('Select action')</option>
                    <option value="email">@lang('Email')</option>
                    <option value="banned">@lang('Banned')</option>
                </select>
            </div>
        </div>
        <div class="card-body collapse show" id="allfollowers">
            <form action="{{ route('escort_admin.followers.multiple_ban') }}" method="POST" id="follower_form" name="follower_form">
                @csrf
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="32">
                                    <input id="btn-select-all" type="checkbox">
                                </th>
                                <th width="132" style="min-width: 132px" class="text-uppercase">@lang('name')</th>
                                <th style="min-width: 244px"></th>
                                <th width="212" style="min-width: 212px"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($followers as $follower)
                            <tr>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $follower->getKey()}}" class="follower-rows" data-email="{{ $follower->follower->email }}"></td>
                                <td>{{ $follower->follower->name ?? '' }}</td>
                                <td>
                                    ( {{-- rating --}}
                                    @include('EscortAdmin::reviews.components.rating', [
                                    'rating' => $follower->followed_user_rating ])
                                    {{-- end rating --}}
                                    from {{ $followers->total() }} votes )
                                </td>
                                <td>
                                    {{-- action --}}
                                    @include('EscortAdmin::followers.components.action')
                                    {{-- end action --}}
                                </td>
                            </tr>
                        @empty
                            @include('EscortAdmin::common.table.no_results', ['colspan' => 6])
                        @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($followers->total() > 0)
                    {{ $followers->links('pagination::escort_admin.pagination') }}
                @endif
            </form>
        </div>
    </div>
</div>
@endsection

@pushAssets('scripts.post')
<script type="text/javascript">
    $(function(){
        var $btn_select_all = $('#btn-select-all');
        var $follower_rows = $('.follower-rows');
        var $total_followers = $follower_rows.length;

        $btn_select_all.on('click', function(){
            if ($btn_select_all.is(':checked')) {
                $follower_rows.prop('checked', true);
            } else {
                $follower_rows.prop('checked', false);
            }
        });

        $follower_rows.on('click', function(){
            if ($follower_rows.filter(':checked').length == $total_followers) {
                $btn_select_all.prop('checked', true);
            } else {
                $btn_select_all.prop('checked', false);
            }
        });

        var $btn_actions = $('#btn-actions');
        $btn_actions.on('change', function(event){
            // event.preventDefault();
            // event.stopPropagation();

            var $action_val = $btn_actions.val();
            if ($action_val == 'select_action') {
                return false;
            }

            var $followers_selected = $follower_rows.filter(':checked');
            if (! $followers_selected.length) {
                fnAlert('No item(s) selected.')
                $btn_actions.val('select_action');
                $btn_actions.selectpicker('refresh');
                return false;
            }

            if ($action_val == 'banned') {
                fnConfirm('', function() {
                    $('#follower_form').get(0).submit();
                }, function() {
                    $btn_actions.val('select_action');
                    $btn_actions.selectpicker('refresh');
                });
                return false;
            } else if ($action_val == 'email') {
                var $selected_emails = [];
                $followers_selected.each( function( i, el ) {
                    var $elem = $( el );
                    $selected_emails.push($elem.attr('data-email'));
                });

                if ($selected_emails.length) {
                    var $redirect_url = '{{ route('escort_admin.followers') }}';
                    var $email_url = '{{ route('escort_admin.emails.compose') }}?emails=' + $selected_emails.join(", ") + '&redirect_url=' + $redirect_url;
                    window.open($email_url, '_blank');
                }
            }

            return false;
        });
    });
</script>
@endPushAssets
