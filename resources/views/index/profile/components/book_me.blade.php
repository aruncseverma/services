<!-- add to favorite -->
<form action="{{ route('index.profile.add_favorite')}}" method="POST" style="display:inline-block;" id="add_favorite_form">
    @csrf
    <input type="hidden" name="id" value="{{ $user->username }}">
</form>
<form action="{{ route('index.profile.remove_favorite')}}" method="POST" style="display:inline-block;" id="remove_favorite_form">
    @csrf
    <input type="hidden" name="id" value="{{ $user->username }}">
</form>
<!-- follow -->
<form action="{{ route('index.profile.follow')}}" method="POST" style="display:inline-block;" id="follow_form">
    @csrf
    <input type="hidden" name="id" value="{{ $user->username }}">
</form>
<form action="{{ route('index.profile.unfollow')}}" method="POST" style="display:inline-block;" id="unfollow_form">
    @csrf
    <input type="hidden" name="id" value="{{ $user->username }}">
</form>
<!-- book me -->
<div class="col-xs-20 col-md-5 panel-bookme">
    <a data-toggle="collapse" href="#bookme_collapse" role="button" aria-expanded="false" aria-controls="bookme_collapse" class="bookmelink">BOOK ME</a>

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

    <a href="#" class="chatwithme"><i class="fa fa-comments"></i><span>CHAT WITH ME</span></a>
    @if(!$isFavorited)
    <a class="addtofav es-submit" data-form-id="add_favorite_form"><i class="fa fa-thumbs-up"></i>Add to Favorites</a>
    @else
    <a class="addtofav es-submit" data-form-id="remove_favorite_form"><i class="fa fa-thumbs-up"></i>Remove to Favorites</a>
    @endif

    @if(!$isFollowed)
    <a class="addtofav es-submit" data-form-id="follow_form"><i class="fa fa-thumbs-up"></i>Follow</a>
    @else
    <a class="addtofav es-submit" data-form-id="unfollow_form"><i class="fa fa-thumbs-up"></i>Unfollow</a>
    @endif
    <div class="dropdown">
        <a data-toggle="dropdown" class="dropdown-toggle"> <i class="fa fa-flag"></i>Report</a>
        </a>
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
                <input type="hidden" name="id" value="{{ $user->username }}">
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