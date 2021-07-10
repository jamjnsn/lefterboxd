@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <header class="card-header">
            <p class="card-header-title">Confirm Password</p>
        </header>

        <div class="card-content">
            {{ __('Please confirm your password before continuing.') }}

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <div class="field">
                    <label for="password" class="label">{{ __('Password') }}</label>

                    <div>
                        <input id="password" type="password" class="input @error('password') is-danger @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <p class="help is-danger" role="alert">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <button type="submit" class="button is-primary">
                        {{ __('Confirm Password') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="button is-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
