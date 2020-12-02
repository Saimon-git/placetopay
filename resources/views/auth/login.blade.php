@extends('layouts.login')

@section('content')
    <div class="w-full max-w-sm mx-auto">
        @if (session()->has('login.error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('login.error') }}</span>
            </div>
        @endif
        <div class="login-card">
            <div class="login-card-title">
                {{ __('Login') }}
            </div>

            <form class="w-full p-6" method="POST" action="/login">
                @csrf

                <div class="flex flex-wrap mb-6">
                    <label for="email" class="block w-full login-form-lavel">
                        {{ __('Username') }}:
                        <input id="username" type="text" class="login-form-input block w-full focus:outline-none focus:shadow-outline{{ $errors->has('username') ? ' border-red-500' : '' }}" name="username" value="{{ old('username') }}" required autofocus>
                        @if ($errors->has('username'))
                        <p class="text-red-500 text-xs italic mt-4">
                            {{ $errors->first('username') }}
                        </p>
                    @endif
                    </label>
                </div>

                <div class="flex flex-wrap mb-6">
                    <label for="password" class="block w-full login-form-lavel">
                        {{ __('Password') }}:
                        <input id="password" type="password" class="login-form-input block w-full focus:shadow-outline{{ $errors->has('password') ? ' border-red-500' : '' }}" name="password" required>
                        @if ($errors->has('password'))
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $errors->first('password') }}
                            </p>
                        @endif
                    </label>
                </div>

                <div class="flex mb-6">
                    <label class="text-sm text-gray-700" for="remember">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        {{ __('Remember Me') }}
                    </label>
                </div>

                <div class="flex flex-wrap items-center">
                    <button type="submit" class="btn primary w-full mb-4">
                        {{ __('Login') }}
                    </button>
                </div>

                <div class="text-center">
                    @if (Route::has('password.request'))
                        <div class="w-full">
                            <a class="text-sm text-green hover:text-orange whitespace-no-wrap no-underline ml-auto" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    @endif
                </div>
            </form>

        </div>
    </div>
@endsection
