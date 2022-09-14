{{-- template for follower row --}}
    <tr>
        <td>{{ $follower->follower->name}}</td>
        <td>
            ( {{-- rating --}}
            @for ($a = 1; $a <= 5; $a++)
                    @if ($a <= ($rate = $follower->followed_user_rating))
                        <i class="fa fa-star @if ($rate < 1) fa-star-half-full @else fa-star @endif text-warning"></i>
                    @else
                        <i class="fa fa-star-o text-warning"></i>
                    @endif
                @endfor
            {{-- end rating --}}
            from {{ $followers->total() }} votes )
        </td>
        @if (! $showFollowerRatingAction)
            <td></td>
        @endif
        <td>
            @include('AgencyAdmin::followers.components.action', ['follower' => $follower])
        </td>
    </tr>
{{-- end template --}}
