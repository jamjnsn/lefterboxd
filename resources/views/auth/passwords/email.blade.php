@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <header class="card-header">
            <p class="card-header-title">Reset Password</p>
        </header>

        <div class="card-content">
            @if (session('status'))
                <article class="message is-success" role="alert">
                    <div class="message-body">
                        {{ session('status') }}
                    </div>
                </article>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="field">
                    <label for="email" class="label">{{ __('E-Mail Address') }}</label>

                    <div>
                        <input id="email" type="email" class="input @error('email') is-danger @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <p class="help is-danger" role="alert">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <div class="field">
                    <button type="submit" class="button is-primary">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
