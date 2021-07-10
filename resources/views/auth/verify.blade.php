@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <header class="card-header">
            <p class="card-header-title">Verify your email address</p>
        </header>

        <div class="card-content">
            @if (session('resent'))
                <article class="message is-success" role="alert">
                    <div class="message-body">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                </article>
            @endif

            {{ __('Before proceeding, please check your email for a verification link.') }}
            {{ __('If you did not receive the email') }},
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit" class="button is-link">{{ __('click here to request another') }}</button>.
            </form>
        </div>
    </div>
</div>
@endsection
