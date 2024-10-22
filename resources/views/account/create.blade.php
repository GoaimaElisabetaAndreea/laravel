@extends('layout.main')

@section('content')
    <form action = "{{ route('account-create-post')}}" method = "post">
        <div class = "field">
            Email: <input type = "text" name = "email" {{ old('email') ? 'value ='.e(old('email')) : '' }}>
            @if($errors->has('email'))
                {{ $errors->first('email') }}
            @endif
        </div>

        <div class = "field">
            Username: <input type = "text" name = "username" {{ old('username') ? 'value ='.e(old('username')).'' : '' }}>
            @if($errors->has('username'))
                {{ $errors->first('username') }}
            @endif
        </div>

        <div class = "field">
            Password: <input type = "password" name = "password">
            @if($errors->has('password'))
                {{ $errors->first('password') }}
            @endif
        </div>

        <div class = "field">
            Password again: <input type = "password" name = "password_again">
            @if($errors->has('password_again'))
                {{ $errors->first('password_again') }}
            @endif
        </div>

        @csrf
        <input type = "submit" value = "Create account">
    </form>
@endsection
