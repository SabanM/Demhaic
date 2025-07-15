<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8" />

        <!-- Optional theme -->
        <link rel="stylesheet" href="{{ asset('/Template/assets/css/bootstrap.min.css') }}">
        <link rel="icon" href="https://doctoraledtech.uva.es/files/2024/04/cropped-DET_NEW_LOGO-1-32x32.png" sizes="32x32">
        <link rel="icon" href="https://doctoraledtech.uva.es/files/2024/04/cropped-DET_NEW_LOGO-1-192x192.png" sizes="192x192">
        <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">

        <title>DET</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>

                .gradient-custom-2 {
                  
                    background-color: #037ade; background-image: linear-gradient(105deg, #037ade 10%, #037ade 90%);
                }

                .gradient-custom-2:hover {
                    background-color: #03e5b7; background-image: linear-gradient(315deg, #03e5b7 0%, #037ade 90%);
                }

                @media (min-width: 768px) {
                    .gradient-form {
                    height: 100vh !important;
                    }
                }
                @media (min-width: 769px) {
                    .gradient-custom-2 {
                    border-top-right-radius: .3rem;
                    border-bottom-right-radius: .3rem;
                    }
                }
                .creinput{
                    width:100%;
                    border-radius:10px;
                    height:40px;
                }

                .language-switch{
                    margin-top:20px;
                }
        </style>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <section class="h-100 gradient-form" style="background-color: #007ACC; background-image: linear-gradient(315deg, #0066B3 0%, #037ade 74%);">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-xl-10">
                        <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
                            <!--<h1><?php echo Session::get('applocale')?></h1>-->
                            <div class="language-selector">
                                <ul class="navbar-nav ml-auto" style="float:right; margin:20px;">
                                    <li class="list-inline-item dropdown notification-list">
                                        <a class="nav-link dropdown-toggle d-flex align-items-center text-dark" 
                                        data-toggle="dropdown" 
                                        href="#" 
                                        role="button" 
                                        aria-haspopup="true" 
                                        aria-expanded="false" 
                                        title="Select Language">
                                            <img 
                                                src="{{ asset('Template/flags/' . (Session::get('applocale') ?? 'en') . '.jpg') }}" 
                                                class="mr-2" 
                                                height="16" 
                                                alt="Flag"
                                            />
                                            <span style="font-size: 10pt; margin-left:5px; text-transform: uppercase;">{{ Session::get('applocale') }}</span>
                                            <i class="fa fa-arrow-down ml-2" style="font-size: 10pt;"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right language-switch">
                                            @foreach (config('languages') as $lang => $language)
                                                @if ($lang != Session::get('applocale'))
                                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('lang.switch', $lang) }}">
                                                        <img 
                                                            src="{{ asset('Template/flags/' . $language['flag-icon'] . '.jpg') }}" 
                                                            style="width: 20px; margin-right: 10px;" 
                                                            alt="Flag"
                                                        />
                                                        <span class="font-weight-bold">{{ $language['display'] }}</span>
                                                    </a>
                                                @endif
                                            @endforeach
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <div class="card-body p-md-5 mx-md-4">

                                <div class="text-center">
                                <img src="/Template/assets/img/logo.png"
                                    style="width: 100px;" alt="logo">
                                <h4 class="mt-2 mb-5 pb-1"><span style="color:#fff">.</span></h4>
                                </div>

                                @if (session('status'))
                                <p style="color:green">{{ __('messages.Your password has been successfully updated !', [], session()->get('applocale')) }}</p>
                                @endif

                                <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <p>{{ __('messages.Please login to your account:', [], session()->get('applocale')) }}</p>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <!--<label class="form-label" for="form2Example11">Username</label>
                                    <input type="email" id="form2Example11" class="form-control"
                                    placeholder="Email address" />-->
                                    <x-input-label for="username" :value="__('messages.Username', [], session()->get('applocale'))" />
                                    <br>
                                    <x-text-input id="username" class="block creinput mt-1 w-full border border-primary" type="username" name="username" :value="old('username')" required autofocus autocomplete="username" />
                                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                                  
                                </div>

                                <div data-mdb-input-init class="form-outline mb-4">
                                    <!--<label class="form-label" for="form2Example22">Password</label>
                                    <input type="password" id="form2Example22" class="form-control" placeholder="Password" />-->
                                    <x-input-label for="password" :value="__('messages.Password', [], session()->get('applocale'))" />
                                    <br>
                                    <x-text-input id="password" class="creinput border border-primary block mt-1 w-full"
                                                    type="password"
                                                    name="password"
                                                    required autocomplete="current-password" />

                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    
                                </div>

                                <div class="text-center pt-1 mb-5 pb-1">
                                    <!--<button data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="button">Log
                                    in</button>-->
                                    <x-primary-button class="ms-3 btn-block fa-lg gradient-custom-2 mb-3">
                                        {{ __('messages.Login', [], session()->get('applocale')) }}
                                    </x-primary-button>
                                    <br>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-muted" href="#!">@lang('messages.Forgot your password?', [], session()->get('applocale'))</a>
                                    @endif
                                </div>

                                <div class="d-flex align-items-center justify-content-center pb-4">
                                    <p class="mb-0 me-2 pt-1">{{ __("messages.Don't have an account?", [], session()->get('applocale')) }}
                                    <a href="{{ route('register') }}"  type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-danger mt-2">{{ __('messages.Create new account', [], session()->get('applocale'))}}</a>
                                </div>

                                </form>
                           
                            </div>
                           
                            <a href="/legal" class="d-block text-center pt-4 pb-4">{{ __("messages.legal_notice_title", [], session()->get('applocale')) }}</a>
     
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <img style="width: 100%; height: 100%; object-fit: cover;" src="/Template/assets/img/login_header.jpg" alt="header">
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</html>
