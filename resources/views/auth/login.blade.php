@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <header class="card-header">
            <p class="card-header-title">Login</p>
        </header>

        <div class="card-content">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field">
                    <label for="email" class="label">{{ __('E-Mail Address') }}</label>

                    <div>
                        <input id="email" type="email" class="input @error('email') is-danger @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <p class="help is-danger" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label for="password" class="label">{{ __('Password') }}</label>

                    <div>
                        <input id="password" type="password" class="input @error('password') is-danger @enderror"
                            name="password" required autocomplete="current-password">

                        @error('password')
                            <p class="help is-danger" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label class="checkbox" for="remember">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <div class="field">
                    <div class="buttons">
                        <button type="submit" class="button is-primary">
                            {{ __('Login') }}
                        </button>

                        @if (Route::has('password.request'))
                            {{-- <a class="button is-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a> --}}
                        @endif
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
