@extends('layout.main')

@section('content')
    <form action = "{{route('account-change-password-post') }}" method = "post">
        <div class = "field">
            Old password: <input type = "password" name = "old_password">
            @if($errors->has('old_password'))
                {{$errors->first('old_password')}}
            @endif
        </div>

        <div class = "field">
            New password: <input type = "password" name = "password">
            @if($errors->has('password'))
                {{$errors->first('password')}}
            @endif
        </div>

        <div class = "field">
            New password again: <input type = "password" name = "password_again">
            @if($errors->has('password_again'))
                {{$errors->first('password_again')}}
            @endif
        </div>

        @csrf
        <input type = "submit" value = "Change password">

    </form>
@endsection
