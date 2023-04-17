@extends('layouts/blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
  <!-- Page -->
  <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')

  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      <div class="authentication-inner">
        <!-- Register -->
        <div class="card">
          <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center">
              <a href="{{url('/')}}" class="app-brand-link gap-2">
                <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'#696cff'])</span>
                <span class="app-brand-text demo text-body fw-bolder">{{config('variables.templateName')}}</span>
              </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-2">{{ __('Welcome to Sneat! 👋') }}</h4>
            <p class="mb-4">{{ __('Please sign-in to your account and start the adventure') }}</p>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')"/>
            <form id="formAuthentication" class="mb-3" action="{{ route('login') }}" method="POST">
              @csrf
              <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email or Username') }}</label>
                <input
                  type="text"
                  class="form-control"
                  id="email"
                  name="email"
                  value="{{ old('email') }}"
                  placeholder="Enter your email or username"
                  autofocus
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
              </div>
              <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">{{ __('Password') }}</label>
                  @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                      <small>{{ __('Forgot Password?') }}</small>
                    </a>
                  @endif
                </div>
                <div class="input-group input-group-merge">
                  <input
                    type="password"
                    id="password"
                    class="form-control"
                    name="password"
                    placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                    aria-describedby="password"
                  />
                  <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                </div>
              </div>
              <div class="mb-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="remember-me"/>
                  <label class="form-check-label" for="remember-me"> {{ __('Remember Me') }} </label>
                </div>
              </div>
              <div class="mb-3">
                <button class="btn btn-primary d-grid w-100" type="submit">{{ __('Sign in') }}</button>
              </div>
            </form>

            <p class="text-center">
              <span>{{ __('New on our platform?') }}</span>
              <a href="{{ route('register') }}">
                <span>{{ __('Create an account') }}</span>
              </a>
            </p>
          </div>
        </div>
        <!-- /Register -->
      </div>
    </div>
  </div>
  <!-- / Content -->
@endsection