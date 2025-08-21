@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="quiz-card w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-6">Login to Your Account</h1>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" class="form-input @error('email') border-red-500 @enderror" 
                       name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-input @error('password') border-red-500 @enderror" 
                       name="password" required autocomplete="current-password">
                @error('password')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group flex items-center">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember" class="ml-2 text-sm text-gray-700">Remember Me</label>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary w-full">
                    Login
                </button>
            </div>

            <div class="text-center mt-4">
                <a class="text-sm text-blue-600 hover:text-blue-800" href="{{ route('register') }}">
                    Don't have an account? Register here
                </a>
            </div>
        </form>
    </div>
</div>
@endsection