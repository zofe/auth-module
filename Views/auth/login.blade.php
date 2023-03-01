@extends('auth::frontend')

@section('main-content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-md-5">

                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">{{ __('Login') }}</h1>
                                </div>

                                @if ($errors->any() || session()->has('log_error'))

                                    <div class="alert alert-danger border-left-danger" role="alert">
                                        <ul class="pl-4 my-2">
                                            @if(session()->has('log_error'))
                                                <li>{{ session('log_error') }}</li>
                                            @else
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}" class="user">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user" name="email" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}" required autofocus>
                                    </div>

                                    <div class="form-group pt-1">
                                        <input type="password" class="form-control form-control-user" name="password" placeholder="{{ __('Password') }}" required>
                                        @if (Route::has('password.request'))
                                            <div class="float-right pt-1">
                                                <a class="small" href="{{ route_lang('password.request') }}">
                                                    {{ __('Forgot Your Password?') }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="form-group pt-1">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="remember">{{ __('Remember Me') }}</label>
                                        </div>
                                    </div>

{{--                                    <div class="form-group">--}}
{{--                                        <div class="custom-control custom-checkbox small">--}}
{{--                                            <input type="checkbox" class="custom-control-input" name="terms" id="terms" {{ old('terms') ? 'checked' : '' }} required="required">--}}
{{--                                            <label class="custom-control-label terms" for="terms">{{ __('Terms of Service') }}</label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            {{ __('Login') }}
                                        </button>
                                    </div>


                                </form>

                                <hr>


                                @if (Route::has('partner.registration'))
                                    <div class="text-center">
                                        {{ __('company.not_a_partner') }} <br>
                                        <a class="small" href="{{ route_lang('partner.registration') }}">{{ __('company.become_partner') }}</a>
                                    </div>
                                @endif

                                @if (Route::has('partner.registration'))
                                    <div class="text-center mt-3">
                                        {{ __('company.did_you_buy_your_first_box_from_one_of_our_distributors') }}<br>
                                        <a class="small" href="{{ route_lang('dealer.registration') }}">{{ __('company.register_your_device') }}</a>
                                    </div>
                                @endif


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
