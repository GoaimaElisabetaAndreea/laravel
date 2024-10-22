@extends('layout.main')

@section('content')
    <form action = "{{ route('account-forgot-password-post') }}" method = "post">
        <div class = "field">
            Email: <input type = "text" name = "email" {{ old('email') ? 'value ='.e(old('email')) : ''}}>
            @if($errors->has('email'))
                {{$errors->first('email')}}
            @endif
        </div>
        @csrf
        <input type = "submit" value = "Recover">
    </form>
@endsection
