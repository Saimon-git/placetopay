@extends('layouts.login')

@section('content')
    <div class="w-full max-w-sm mx-auto">
        <div class="login-card">

            <div class="login-card-title">
                {{ __('Reset Password') }}
            </div>

            <form class="w-full p-6" method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="flex flex-wrap mb-6">
                    <label for="email" class="block w-full login-form-lavel">
                        {{ __('E-Mail Address') }}:
                        <input id="email" type="email" class="login-form-input block w-full focus:outline-none focus:shadow-outline{{ $errors->has('email') ? ' border-red' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $errors->first('email') }}
                            </p>
                        @endif
                    </label>

                </div>

                <div class="flex flex-wrap mb-6">
                    <label for="password" class="block w-full login-form-lavel">
                        {{ __('Password') }}:
                        <input id="password" type="password" class="login-form-input block w-full focus:outline-none focus:shadow-outline{{ $errors->has('password') ? ' border-red' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $errors->first('password') }}
                            </p>
                        @endif
                    </label>

                </div>

                <div class="flex flex-wrap mb-6">
                    <label for="password-confirm" class="block w-full login-form-lavel">
                        {{ __('Confirm Password') }}:
                        <input id="password-confirm" type="password" class="login-form-input block w-full focus:outline-none focus:shadow-outline" name="password_confirmation" required>
                    </label>

                </div>

                <div class="flex flex-wrap">
                    <button type="submit" class="btn primary">
                        {{ __('Reset Password') }}
                    </button>
                </div>
            </form>

        </div>
    </div>
@endsection
