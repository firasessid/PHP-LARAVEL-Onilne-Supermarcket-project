<div class="favorite-list-item">
    @if($user)
        <div data-id="{{ $user->id }}" data-action="0" class="avatar av-m"
            style="background-image: url('{{ Chatify::getUserWithAvatar($user)->avatar }}');">
        </div>
        <p>{{ strlen($user->name) > 5 ? substr($user->name,0,6).'..' : $user->name }}</p>

@else

<div data-id="{{ $user->id }}" data-action="0" class="avatar av-m"
    style="background-image: url('{{ aaset('assets/imgs/people/avatar-2.png') }}');">
</div>

        @endif
</div>


