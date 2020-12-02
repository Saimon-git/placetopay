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
                The payment has been approved
            </div>



            <div class="text-center">
                <h2>
                    The payment is successfully.
                </h2>
            </div>

                <div class="flex flex-wrap items-center">
                    <a href="/orders" class="btn primary mb-4 mt-4 mx-auto">
                        Ok
                    </a>
                </div>



        </div>
    </div>
@endsection
