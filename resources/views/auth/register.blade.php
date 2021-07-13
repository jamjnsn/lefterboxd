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
                    <h2 class="label">Terms of Service</h2>
                    <div class="tos textarea">
                        <p>I agree to rate movies according to their Leftism as determined with an objective measurement
                            using the proprietary solution as outlined in the audio clip located at
                            <a href="https://globehell.libsyn.com/episode-53-lefterboxd" rel="noopener" target="new">https://globehell.libsyn.com/episode-53-lefterboxd</a>.</p>

                        <p>By creating this account, I certify that I have listened to and comprehensively understood the crucial details and methodology
                            outlined in the above linked audio clip. All movies for which I submit a vote have been personally viewed using some apparatus
                            to obfuscate the rightmost third of the display device used in the viewing.</p>

                        <p>TODO: elaborate on the specifics of the terms of service</p>

                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam odio nisi, tincidunt ut turpis sit amet, suscipit elementum sem. Maecenas lobortis augue eu dui iaculis gravida. Nullam pharetra nisl quis sem viverra pretium. Cras nec tellus tincidunt, euismod lorem nec, feugiat arcu. In pretium nunc metus, a interdum ligula gravida quis. Sed varius at tortor in laoreet. Nulla sagittis est et varius iaculis.</p>
                    </div>

                    <label class="checkbox" for="tos">
                        <input type="checkbox" name="tos" id="tos" {{ old('tos') ? 'checked' : '' }}>
                        {{ __('I agree') }}
                    </label>
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
