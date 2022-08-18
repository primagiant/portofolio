@extends('auth.layouts.app')

@section('content')
    <style>
       .auth .brand-logo img{
           width: 50px;
           height: 50px;
       } 
       .auth .brand-logo span{
           font-family: "Nunito", sans-serif;
           font-weight: 700;
           font-size: 25px;
           margin-left: 8px;
       } 
    </style>
    <div class="auth-form-light text-left py-5 px-4 px-sm-5 rounded shadow">
        <div class="brand-logo d-flex justify-content-center align-items-center">
            <img src="{{ asset('images/logo-mini.svg') }}" alt="logo">
            <span>Portofolio</span>
        </div>
        <h6 class="font-weight-light">Log in to continue.</h6>
        <form action="{{ route('login') }}" method="POST" class="pt-3">
            @csrf
            <div class="form-group">
                <input type="email" name="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
                    id="exampleInputEmail1" placeholder="Email">
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-group">
                <input type="password" name="password"
                    class="form-control form-control-lg @error('password') is-invalid @enderror" id="exampleInputPassword1"
                    placeholder="Password">
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                    LOGIN
                </button>
            </div>
            {{-- <div class="my-2 d-flex justify-content-between align-items-center">
                <div class="form-check">
                    <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input">
                        Keep me log in
                    </label>
                </div>
                <a href="#" class="auth-link text-black">Forgot password?</a>
            </div> --}}
        </form>
    </div>
@endsection
