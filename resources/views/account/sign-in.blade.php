@extends('layout.main')

@section('content')
    <form action = "{{route('account-sign-in-post') }}" method = "post">
        <div class = "field">
            Email: <input type = "text" name = "email" {{ old('email') ? ' value = '.old('email') : '' }}>
            @if($errors->has('email'))
                {{$errors->first('email')}}
            @endif

        </div>

        <div class = "field">
            Password: <input type = "password" name = "password">
            @if($errors->has('password'))
                {{ $errors->first('password') }};
            @endif
        </div>

        @csrf
        <input type = "submit" value =  "Sign in">
    </form>
@endsection
