@extends('layouts.mobile')

@section('content')

@if ($errors->any())
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

<h6>Считайте авторизационный штрихкод:</h6>

    <div>{{ __('Login') }}</div>

    <form method="POST" action="{{ route('m.login') }}" aria-label="{{ __('Login') }}">
        @csrf

        <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

        @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif


        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

        @if ($errors->has('password'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('password') }}</strong>
            </span>
        @endif

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
            </label>
        </div>

        <button type="submit" class="btn btn-primary">
            {{ __('Login') }}
        </button>

    </form>

@endsection
