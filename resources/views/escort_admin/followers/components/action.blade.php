<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <i class="fa fa-star"></i> Rate Follower
</button>
<div class="dropdown-menu">
    @if ($follower->follower_user_rating == 1)
        <a class="dropdown-item text-warning">
    @else
        <a class="dropdown-item" href="{{ route('escort_admin.followers.rate_customer',[
            'id'=> $follower->getKey(),
            'rate' => 1
        ])}}">
    @endif
            <i class="fa fa-star"></i>
            <i class="fa fa-star-o"></i>
            <i class="fa fa-star-o"></i>
            <i class="fa fa-star-o"></i>
            <i class="fa fa-star-o"></i>
        </a>
    @if ($follower->follower_user_rating == 2)
        <a class="dropdown-item text-warning">
    @else
        <a class="dropdown-item" href="{{ route('escort_admin.followers.rate_customer',[
            'id'=> $follower->getKey(),
            'rate' => 2
        ])}}">
    @endif
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star-o"></i>
            <i class="fa fa-star-o"></i>
            <i class="fa fa-star-o"></i>
        </a>
    @if ($follower->follower_user_rating == 3)
        <a class="dropdown-item text-warning">
    @else
        <a class="dropdown-item" href="{{ route('escort_admin.followers.rate_customer',[
            'id'=> $follower->getKey(),
            'rate' => 3
        ])}}">
     @endif
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star-o"></i>
            <i class="fa fa-star-o"></i>
        </a>
    @if ($follower->follower_user_rating == 4)
        <a class="dropdown-item text-warning">
    @else
        <a class="dropdown-item" href="{{ route('escort_admin.followers.rate_customer',[
            'id'=> $follower->getKey(),
            'rate' => 4
        ])}}">
    @endif
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star-o"></i>
        </a>
    @if ($follower->follower_user_rating == 5)
        <a class="dropdown-item text-warning">
    @else
        <a class="dropdown-item" href="{{ route('escort_admin.followers.rate_customer',[
            'id'=> $follower->getKey(),
            'rate' => 5
        ])}}">
    @endif
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
            <i class="fa fa-star"></i>
        </a>
</div>
<a href="{{ route('escort_admin.emails.compose', ['emails'=> $follower->follower->email, 'redirect_url' => route('escort_admin.followers')]) }}" target="_blank">
    <i class="mdi mdi-email"></i>
</a>
<a href="{{ route('escort_admin.followers.ban',['id'=> $follower->getKey()])}}" class="es es-confirm">
    <i class="mdi mdi-alert-outline"></i>
</a>

