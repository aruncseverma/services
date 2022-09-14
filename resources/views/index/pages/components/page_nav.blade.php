@php
$level = $level ?? 1;
$isMobile = $isMobile ?? false;
$parent_id = $parent_id ?? 0;
@endphp

@if(!$isMobile)

@if($level == 1)
<div class="page-navs">
    @endif
    @if($pages->count())
    @if($level>1)
    <i class="fa fa-chevron-down" aria-hidden="true"></i>
    @endif
    <ul class="level-{{ $level }}">
        @foreach($pages as $page)
        <li>
            <a href="{{ $page->getPostUrl() }}">{{ $page->getDescription($langCode, true)->title ?? '--' }}</a>
            @include('Index::pages.components.page_nav', [
            'parent_id' => $page->getKey(),
            'level' => ($level+1),
            'isMobile' => $isMobile,
            ])
        </li>
        @endforeach
    </ul>
    @endif
    @if($level == 1)
</div>
@endif

@else

@if($level == 1)

<button type="button" class="btn btn-default" id="page-nav-open"><i class="fa fa-bars" aria-hidden="true"></i></button>

<div class="page-navs-m" id="page-navs-m">
    <button type="button" class="btn btn-danger" id="page-nav-close"><i class="fa fa-close" aria-hidden="true"></i> Close</button>
    @endif
    @if($pages->count())
    @if($level>1)
    <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#page-navs-{{ $parent_id }}">
        <i class="fa fa-chevron-up" aria-hidden="true"></i>
    </button>
    @endif
    <ul id="page-navs-{{ $parent_id }}" class="level-{{ $level }} @if($level>1) collapse @endif" @if($level>1) style="display2:none;" @endif>
        @foreach($pages as $page)
        <li>
            <a href="{{ $page->getPostUrl() }}">{{ $page->getDescription($langCode, true)->title ?? '--' }}</a>
            @include('Index::pages.components.page_nav', [
            'parent_id' => $page->getKey(),
            'level' => ($level+1),
            'isMobile' => $isMobile,
            ])
        </li>
        @endforeach
    </ul>
    @endif
    @if($level == 1)
</div>

@pushAssets('post.scripts')
<script>
    $(function() {
        var $pageNavsBtns = $('.page-navs-m ul button');
        if ($pageNavsBtns.length) {
            $pageNavsBtns.on("click", function() {
                var $elm = $(this).find('i');
                if ($elm.hasClass('fa-chevron-down')) {
                    $elm.removeClass('fa-chevron-down');
                    $elm.addClass('fa-chevron-up');
                } else {
                    $elm.removeClass('fa-chevron-up');
                    $elm.addClass('fa-chevron-down');
                }
            });
        }
        var $isOpenPageNavM = false;
        var $pageNavM = $('#page-navs-m');
        var $navOpen = $('#page-nav-open');
        $navOpen.click(function() {
            $pageNavM.show();
            $isOpenPageNavM = true;
        });
        var $navClose = $('#page-nav-close');
        $navClose.click(function() {
            $pageNavM.hide();
            $isOpenPageNavM = false;
        });

        // close page nav mobile when page nav mobile is open and page resize to mobile width
        $(window).resize(function() {
            $w = $(this).width();
            if ($w >= 700 && $isOpenPageNavM === true) {
                $pageNavM.hide();
                $isOpenPageNavM = false;
            }
        });
    });
</script>
@endPushAssets

@endif

@endif