<!-- review active -->
<div class="col-xs-20 panel-reviewactive collapse" id="review_collapse">

    <div class="panel panel-primary">
        <div class="panel-heading widget_header widget_accordian_title">
            <a class="btn-minimize"><i class="fa fa-window-minimize"></i></a>
            <h3 class="panel-title">Write a review</h3>
        </div>
        <div class="panel-body widget_accordian_content">
            <form class="default_form es es-validation es-ajax" action="{{ route('index.profile.add_review') }}" method="POST" id="review_form">
                @csrf
                <input type="hidden" name="id" value="{{ $user->username ?? '' }}">
                <div class="row">
                    <div class="col-md-10 col-lg-5 col-lg-push-5 ">
                        <div class="row">
                            <div class="col-lg-20" style="text-align: center">Rating
                                {{-- rating --}}
                                @include('Index::profile.components.rating', ['rating_name' => 'rating', 'rating_value' => old('rating'), 'rating_id' => 'rating'])
                                {{-- end rating --}}
                            </div>
                            @include('Index::common.form.error', ['key' => 'rating'])
                            <div class="text-center">
                                <label for="rating" class="es-required" style="display:none;" data-error-after-label="1">Rating</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-10 col-lg-10 col-lg-push-5 bookmeactive-texts">
                        <div class="row">
                            <div class="col-lg-5">
                                Review
                            </div>
                            <div class="col-lg-15">
                                <label for="content" class="es-required" style="display:none;">Content</label>
                                <textarea id="content" class="form-control" rows="5" style="resize: none;" placeholder="Message" name="content">{{ old('content') }}</textarea>
                                @include('Index::common.form.error', ['key' => 'content'])
                            </div>
                        </div>
                        <div class="row">
                            <a href="#" style="margin-bottom: 12px; display: block; float: right;" class="col-xs-10 col-sm-5">
                                <input type="submit" value="SUBMIT" class="general-button" style="width: 100%;" id="add_review_button">
                            </a>
                            <a style="margin-bottom: 12px; display: block;" class="cancel-butt2 col-xs-10 col-sm-5" href="#review_collapse" role="button" aria-expanded="true" aria-controls="review_collapse" data-toggle="collapse"><input type="reset" value="CANCEL" class="general-button" style="width: 100%;"></a>

                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>