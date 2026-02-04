@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="width: 400px;">
        <h3 class="text-center">Login BLT-APP</h3>
        <div class="d-flex ">
            <a href="{{ url('/auth/google')  }}" class="btn btn-white w-100 shadow-sm border">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48" style="vertical-align:middle;margin-right:6px;">
                    <path fill="#4285F4" d="M24 9.5c3.54 0 6.7 1.22 9.19 3.22l6.85-6.85C35.44 2.36 29.97 0 24 0 14.61 0 6.27 5.7 2.13 14.01l8.01 6.23C12.36 13.16 17.73 9.5 24 9.5z" />
                    <path fill="#34A853" d="M46.1 24.5c0-1.64-.15-3.22-.42-4.75H24v9.02h12.44c-.54 2.92-2.17 5.39-4.62 7.06l7.19 5.59C43.73 37.36 46.1 31.44 46.1 24.5z" />
                    <path fill="#FBBC05" d="M10.14 28.24c-.62-1.86-.98-3.84-.98-5.89s.36-4.03.98-5.89l-8.01-6.23C.73 13.97 0 18.81 0 24c0 5.19.73 10.03 2.13 14.01l8.01-6.23z" />
                    <path fill="#EA4335" d="M24 48c6.48 0 11.93-2.14 15.91-5.84l-7.19-5.59c-2.01 1.35-4.59 2.15-8.72 2.15-6.27 0-11.64-3.66-13.86-8.74l-8.01 6.23C6.27 42.3 14.61 48 24 48z" />
                </svg>
                Login with Google
            </a>
        </div>
    </div>
</div>
@endsection
