@if($categories)
<div class="used-categories">
    <h2>@lang('Categories')</h2>
    <ul>
        @foreach($categories as $cat)
        <li>
            @php($catName = $cat->getDescription($langCode, true)->name)
            <a href="{{ route('index.posts.categories.redirect', ['category_name' => $catName]) }}">{{ $catName }}</a>
        </li>
        @endforeach
    </ul>
</div>
@endif
@pushAssets('post.styles')
<style>
    .used-categories {
        margin-top: 50px;
    }

    .used-categories h2 {
        text-align: left;
        margin-bottom: 30px;
    }

    .used-categories li a {
        color: #d52e40;
    }

    .used-categories li:first-child {
        margin-top: 0;
    }

    .used-categories li {
        margin: 20px 0 0 0;
        font-weight: bold;
        font-size: 18px;
    }
</style>
@endPushAssets