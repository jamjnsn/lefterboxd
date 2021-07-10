@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <header class="card-header">
            <p class="card-header-title">Sign up</p>
        </header>

        <div class="card-content">
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="field">
                    <label for="username" class="label">{{ __('Username') }}</label>

                    <div>
                        <input id="username" type="text" class="input @error('username') is-danger @enderror"
                            name="username" value="{{ old('name') }}" required autocomplete="username" autofocus>

                        @error('username')
                            <p class="help is-danger" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="label">{{ __('E-Mail Address') }}</label>

                    <div>
                        <input id="email" type="email" class="input @error('email') is-danger @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email">

                        @error('email')
                            <p class="help is-danger" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label for="password" class="label">{{ __('Password') }}</label>

                    <div>
                        <input id="password" type="password" class="input @error('password') is-danger @enderror"
                            name="password" required autocomplete="new-password">

                        @error('password')
                            <p class="help is-danger" role="alert">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <label for="password-confirm" class="label">{{ __('Confirm Password') }}</label>

                    <div>
                        <input id="password-confirm" type="password" class="input" name="password_confirmation"
                            required autocomplete="new-password">
                    </div>
                </div>

                <div class="field">
                    <button type="submit" class="button is-primary">
                        {{ __('Sign up') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
