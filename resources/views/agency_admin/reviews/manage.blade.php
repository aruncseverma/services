@extends('AgencyAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-format-quote"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#allreviews">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('All Agency Reviews')</span>
        </div>
        <div class="card-header-sub">
            @lang('Read and reply to your reviews')
        </div>
        <div class="card-body collapse show" id="allreviews">
            {{-- agency --}}
            @if (old('notify') == 'agency')
                @include('AgencyAdmin::common.notifications')
            @endif
            @include('AgencyAdmin::reviews.components.reviews', ['reviews' => $agencyReviews, 'notify' => 'agency'])
            {{-- end agency --}}
        </div>
    </div>
</div>

<div class="col-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#escortreviews">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('All Escort Reviews')</span>
        </div>
        <div class="card-header-sub">
            @lang('Read and reply to your reviews')
        </div>
        <div class="card-body collapse show" id="escortreviews">
            {{-- escorts --}}
            @if (old('notify') == 'escorts')
                @include('AgencyAdmin::common.notifications')
            @endif
            @include('AgencyAdmin::reviews.components.reviews', ['reviews' => $escortsReviews, 'notify' => 'escorts'])
            {{-- end escorts --}}
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