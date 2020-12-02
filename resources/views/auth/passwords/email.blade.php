@extends('layouts.login')

@section('content')
    <div class="w-full max-w-sm mx-auto">
        @if (session('status'))
            <div class="text-sm border border-t-8 rounded text-green-700 border-green-600 bg-green-100 px-3 py-4 mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="login-card">

            <div class="login-card-title">
                {{ __('Reset Password') }}
            </div>

            <form class="w-full p-6" method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="flex flex-wrap mb-6">
                    <label for="email" class="block w-full login-form-lavel">
                        {{ __('E-Mail Address') }}:

                        <input id="email" type="email" class="login-form-input block w-full focus:outline-none focus:shadow-outline{{ $errors->has('email') ? ' border-red' : '' }}" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $errors->first('email') }}
                            </p>
                        @endif
                    </label>

                </div>

                <div class="flex flex-wrap">
                    <button type="submit" class="btn primary">
                        {{ __('Send Password Reset Link') }}
                    </button>

                    <p class="w-full text-xs text-center text-grey-dark mt-8 -mb-4">
                        <a class="text-green hover:text-orange no-underline" href="{{ route('login') }}">
                            Back to login
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection
