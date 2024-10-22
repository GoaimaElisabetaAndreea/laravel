<nav>
    <ul>
        <li><a href="{{ route('home') }}">Home</a></li>

        @if(Auth::check())
            <li><a href = "{{ route('account-sign-out') }}">Sign out</a></li>
            <li><a href = "{{ route('account-change-password') }}">Change password</a></li>
        @else
            <li><a href = "{{route('account-sign-in')}}">Sign in</a></li>
            <li><a href= "{{ route('account-create') }}">Create an account</a></li>
            <li><a href = "{{route('account-forgot-password')}}">I forgot my password</a></li>
        @endif
    </ul>
</nav>
