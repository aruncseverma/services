@php
$totalApprovedComments = $post->totalApprovedComments();
@endphp

@if($totalApprovedComments > 0 || $post->isAllowedComment())
<div id="comment-container">

    @if($totalApprovedComments > 0)
    <h2 class="comment-title">{{ $totalApprovedComments }} replies on “{{ $post->getDescription($langCode, true)->title }}”</h2>

    <div class="comments">
        @include('Index::posts.components.comments.list', [
        'post_id' => $post->getKey(),
        ])
    </div>
    <hr id="comment_divider" />
    @endif

    @if($commentShowForm)
    <div id="comment_form">
        <h2 class="comment-form-title">Leave a Reply</h2>
        @include('Index::posts.components.comments.form', [

        ])
    </div>
    @elseif($commentShowLogin)
    <h2>Leave a Reply</h2>
    You must be <a href="#" id="btn-comment-login">logged in</a> to post a comment.
    <div id="comment-login-container">
        <div id="comment_login" style="display:none;">
            <h3>Login</h3>
            @php($redirectUrl = url()->current())
            <div class="form-group">
                <label for="auth_type">Authentication Type</label>
                <select class="form-control" id="auth_type">
                    <option value="{{ route('admin.auth.login_form', ['redirect_url'=> $redirectUrl]) }}">@lang('Admin')</option>
                    <option value="{{ route('agency_admin.auth.login_form', ['redirect_url'=> $redirectUrl]) }}">@lang('Agency')</option>
                    <option value="{{ route('escort_admin.auth.login_form', ['redirect_url'=> $redirectUrl]) }}">@lang('Escort')</option>
                    <option value="{{ route('member_admin.auth.login_form', ['redirect_url'=> $redirectUrl]) }}">@lang('Member')</option>
                </select>
            </div>
            <button type="button" class="btn btn-success" id="btn-ok-comment-login">@lang('OK')</button>
            <button type="button" class="btn btn-danger" id="btn-cancel-comment-login">@lang('Cancel')</button>
        </div>
    </div>
    @else
    <p>Comments are closed.</p>
    @endif
</div>

@pushAssets('scripts.post')
{{-- continents to countries select form --}}
<script type="text/javascript">
    $(function() {
        var $commentContainer = $('#comment-container');
        var $commentAuthType = $commentContainer.find('#auth_type');
        var $commentLoginBtn = $commentContainer.find('#btn-ok-comment-login');
        var $commentLoginContainer = $commentContainer.find('#comment-login-container');

        $commentContainer
            .on('click', '.btn-reply-comment', function() {
                var $elm = $(this);
                // comment form
                var $commentForm = $commentContainer.find('#comment_form');
                // add parent_id
                $commentForm.find('#comment_parent_id').val($elm.data('comment-id'));
                // display cancel reply
                $commentForm.find('#btn-cancel-comment-reply').show();

                // $elm.after($commentForm);
                var $parent = $elm.closest('.comment-items');
                if ($parent.length) {
                    var $replyContainer = $parent.find('.comment-reply-container:eq(0)');
                    if ($replyContainer.length) {
                        $replyContainer.append($commentForm);
                    }
                }

                $commentForm.find('#comment_content').focus();

                // remove validation error messages
                fnRemoveInputErrors($commentForm);
            })
            .on('click', '#btn-cancel-comment-reply', function() {
                var $elm = $(this);
                var $parentContainer = $elm.closest('.comment-items');
                if ($parentContainer.length) {
                    // comment form
                    var $commentForm = $parentContainer.find('#comment_form');
                    // remove parent_id
                    $commentForm.find('#comment_parent_id').val('');
                    // hiden cancel reply
                    $commentForm.find('#btn-cancel-comment-reply').hide();
                    $commentContainer.append($commentForm);

                    // remove validation error messages
                    fnRemoveInputErrors($commentForm);
                }
            })
            .on('click', '.btn-comment-login, #btn-comment-login', function() {
                event.preventDefault();
                var $elm = $(this);
                // comment login
                var $commentLogin = $commentContainer.find('#comment_login');

                // $elm.after($commentLogin);
                if ($elm.attr('id') == 'btn-comment-login') {
                    if ($commentLoginContainer.length) {
                        $commentLoginContainer.append($commentLogin);
                    }
                } else {
                    var $parent = $elm.closest('.comment-items');
                    if ($parent.length) {
                        var $replyContainer = $parent.find('.comment-reply-container:eq(0)');
                        if ($replyContainer.length) {
                            $replyContainer.append($commentLogin);
                        }
                    }
                }

                $commentLogin.show();
            })
            .on('click', '#btn-cancel-comment-login', function() {
                var $elm = $(this);
                // comment login
                var $commentLogin = $commentContainer.find('#comment_login');
                if ($commentLogin.length) {
                    $commentLogin.hide();
                    $commentContainer.append($commentLogin);
                }
            });

        if ($('#comment_error').length) {
            // open prev selected reply form when submitting form w/ error input
            var $parentComment = $commentContainer.find('#comment_parent_id');
            if ($parentComment.length && $parentComment.val() > 0) {
                var $replyButton = $commentContainer.find('.btn-reply-comment[data-comment-id="' + $parentComment.val() + '"]');
                if ($replyButton.length) {
                    $replyButton.trigger('click');
                }
            } else {
                // focus to comment form if there's an error
                $('html').animate({
                    scrollTop: $("#comment_form").offset().top
                }, 500);
            }
        }

        $commentLoginBtn.click(function() {
            window.location.href = $commentAuthType.val();
        });
    });
</script>
@endPushAssets

@endif