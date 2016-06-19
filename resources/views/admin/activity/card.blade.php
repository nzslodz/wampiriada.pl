<div class="user-card">
    @if($image)
        <div class="image pull-left">
            <a href="https://facebook.com/{{ $user->facebook_user_id }}"><img src="{{ $image }}"></a>
        </div>
    @endif

    <div class="person">
        <p><strong><i class="fa fa-list"></i> <a href="{{ url('admin/activity/profile/' . $user->id)}}">aktywności ({{ $activity_count }})</a></strong></p>

        @if($user->email)
        <p><i class="fa fa-envelope"></i> {{ $user->email }}</p>
        @endif
        @if($user->facebook_user_id)
            <p><i class="fa fa-facebook-square"></i> <a href="https://facebook.com/{{ $user->facebook_user_id }}"> facebook</a></p>
        @endif
    </div>
</div>
