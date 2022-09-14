<a hre="#" id="btn-cancel-comment-reply" style="display:none;">Cancel Reply</a>

@if($commentAuth)
<div id="comment-logged-in-as">
    <a href="{{ $commentProfileUrl }}">Logged in as {{ $commentAuthType }}.</a>
    @if($commentLogoutUrl)<a href="{{ $commentLogoutUrl }}">Log out?</a>@endif
</div>
@else
<p class="comment-notes">Your email address will not be published. Required fields are marked *</p>
@endif


<form action="{{ route('index.posts.comments.save') }}" method="POST" class="row es es-validation">
    @csrf
    @if(!empty(old('comment')))
    <input type="hidden" id="comment_error" value="1" />
    @endif
    <input type="hidden" name="comment[post_id]" id="comment_post_id" value="{{ $post->getKey() }}" />
    <input type="hidden" name="comment[parent_id]" id="comment_parent_id" value="{{ old('comment.parent_id') }}" />
    @include('Index::common.form.error', ['key' => 'comment.post_id'])
    @include('Index::common.form.error', ['key' => 'comment.parent_id'])


    <div class="form-group col-lg-20">
        <label for="comment_content" class="es-required" data-attribute="Comment">Comment *</label>
        <textarea name="comment[content]" id="comment_content" class="form-control">{{ old('comment.content') }}</textarea>
        @include('Index::common.form.error', ['key' => 'comment.content'])
    </div>

    @if(!$commentAuth)
    <div class="form-group col-lg-10">
        <label for="comment_name" class="es-required" data-attribute="Name">Name *</label>
        <input type="text" class="form-control" name="comment[name]" id="comment_name" value="{{ old('comment.name') }}" />
        @include('Index::common.form.error', ['key' => 'comment.name'])
    </div>

    <div class="form-group col-lg-10">
        <label for="comment_email" class="es-required es-email" data-attribute="Email">Email *</label>
        <input type="email" class="form-control" name="comment[email]" id="comment_email" value="{{ old('comment.email') }}" />
        @include('Index::common.form.error', ['key' => 'comment.email'])
    </div>

    <div class="form-group col-lg-20">
        <label for="comment_url">Website</label>
        <input type="text" class="form-control" name="comment[url]" id="comment_url" value="{{ old('comment.url') }}" />
        @include('Index::common.form.error', ['key' => 'comment.url'])
    </div>

    {{--Save my name, email, and website in this browser for the next time I comment.--}}

    @endif
    <button type="submit" class="btn btn-danger btn-lg text-uppercase waves-effect waves-light">Post Comment</button>
</form>