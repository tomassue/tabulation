@extends('layouts.app')

@section('content')

@guest
<!-- Login Container -->
<div class="min-vh-100 d-flex align-items-center justify-content-center position-relative">
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-8">

                <!-- Logo -->
                <div class="text-center mb-4">
                    <a href="#" class="d-inline-flex align-items-center gap-2">
                        <img src="{{ asset('img/seallogo.png') }}" alt="Logo" style="height: 70px;">
                        <img src="{{ asset('img/risebig.png') }}" alt="Logo" style="height: 50px;">
                        <img src="{{ asset('img/logo1.png') }}" alt="Logo" style="height: 50px;">
                        <img src="{{ asset('img/tourismlogo.png') }}" alt="Logo" style="height: 50px;">
                        <img src="{{ asset('img/ictlogo.png') }}" alt="Logo" style="height: 50px;">

                        <!-- <h4 class="fw-bold mb-0 text-primary">Tabulation System</h4> -->
                    </a>
                </div>

                <!-- Login Card -->
                <div class="card shadow-lg rounded-4 border-0">
                    <div class="card-body p-5">

                        <div class="mb-4 text-center">
                            <h5 class="fw-semibold mb-1">Tabulation System</h5>
                            <p class="text-muted small">Enter your credentials to continue</p>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-semibold">Email Address</label>
                                <input id="email" type="email"
                                    class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autofocus>

                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <input id="password" type="password"
                                    class="form-control form-control-lg rounded-3 @error('password') is-invalid @enderror"
                                    name="password" required>

                                @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg rounded-3">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </form>

                    </div>
                </div>

                <!-- Optional footer -->
                <div class="text-center mt-4 text-muted small">
                    &copy; {{ now()->year }} City Management Information Systems and Innovation Department.<br>All rights reserved.
                </div>

            </div>
        </div>
    </div>
</div>
@endguest

@endsection