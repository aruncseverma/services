<div class="col-xs-20 panel-bookme">
    <div>
        <a href="#">
            <img src="{{ asset('assets/theme/index/default/images/index/icon-bookme-phone.png') }}" alt="phone" title="phone">
        </a>
        <a href="#">
            <img src="{{ asset('assets/theme/index/default/images/index/icon-bookme-telegram.png') }}" alt="telegram" title="telegram">
        </a>
        <a href="#">
            <img src="{{ asset('assets/theme/index/default/images/index/icon-bookme-skype.png') }}" alt="skype" title="skype">
        </a>
        <a href="#">
            <img src="{{ asset('assets/theme/index/default/images/index/icon-bookme-whatsapp.png') }}" alt="whatsapp" title="whatsapp">
        </a>
        <a href="#" style="margin-right: 0">
            <img src="{{ asset('assets/theme/index/default/images/index/icon-bookme-viber.png') }}" alt="viber" title="viber">
        </a>
    </div>

    @if(!$isFavorited)
    <a class="addtofav es-submit" data-form-id="add_favorite_form" style="margin-right:4px"><i class="fa fa-star"></i>Add to Favorites</a>
    @else
    <a class="addtofav es-submit" data-form-id="remove_favorite_form" style="margin-right:4px"><i class="fa fa-star"></i>Remove to Favorites</a>
    @endif
    
    @if(!$isFollowed)
    <a class="addtofav es-submit" data-form-id="follow_form"><i class="fa fa-heart"></i>Follow</a>
    @else
    <a class="addtofav es-submit" data-form-id="unfollow_form"><i class="fa fa-heart"></i>Unfollow</a>
    @endif
    <div class="dropdown" style="width: 100%">
        <a data-toggle="dropdown" class="dropdown-toggle btn-danger"> <i class="fa fa-flag"></i>Report</a></a>
        <ul class="dropdown-menu">
            <li><a class="add-report" data-type="suspicious_pics">Suspicious Pics</a></li>
            <li><a class="add-report" data-type="bad_phone_num">Bad Phone Num</a></li>
            <li><a data-toggle="modal" data-target="#report_other_concern">Other Concern</a></li>
        </ul>
    </div>
</div>

<!-- The Modal -->
<div class="modal" id="report_other_concern">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="default_form" action="{{ route('index.profile.add_report') }}" method="POST" id="report_form">
                @csrf
                <input type="hidden" name="type" value="other_concern">
                <input type="hidden" name="id" value="{{ $agency->username }}">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title" style="float: left;">Other Concern</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <textarea name="content" class="form-control" required></textarea>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@pushAssets('post.scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var $reportForm = $('#report_form');
        if ($reportForm.length) {
            $('.add-report').click(function() {
                var $elm = $(this);
                var $type = $elm.attr('data-type');
                if (typeof $type !== 'undefined' && $type != '') {
                    $reportForm.find('input[name="type"]').val($type);
                    $reportForm.submit();
                }
            });
        }
    });
</script>
@endPushAssets