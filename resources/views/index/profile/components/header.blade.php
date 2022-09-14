<div class="col-xs-20 boxpanel">
    <div>{{ $user->name ?? '' }}</div>
    <div>
        <span>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore. Lorem ipsum dolor sit amet, consectetur</span>
        <span>@if ($user->last_online) Last online: {{ $user->last_online }} - @endif Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor. Lorem ipsum dolor sit amet.</span>
    </div>
</div>
