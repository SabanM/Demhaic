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
        </style>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <section class="h-100 gradient-form" style="background-color: #03e5b7; background-image: linear-gradient(315deg, #03e5b7 0%, #037ade 74%);">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-xl-10">
                        <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-6">
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
                                <h4 class="mt-2 pb-1"><span style="color:#fff">.</span></h4>
                                </div>
                                
                         

                            <form method="GET" action="{{ route('password.getSecurityQuestions') }}">
                                @csrf
                                <p class="mb-4">
                                    {{ __('messages.Forgot your password? No problem. Please answer your security questions, and we will allow you to reset your password.', [], session()->get('applocale')) }}
                                </p>
                                 <!-- Error Message Display -->
                                @if ($errors->has('username_not_found'))
                                    <p style="color:red" class="text-red-500 text-sm mt-2">
                                        {{ $errors->first('username_not_found', [], session()->get('applocale')) }}
                                    </p>
                                @endif
                                
                                <!-- Username Input -->
                                <div>
                                    <x-input-label for="username" :value="__('messages.Username', [], session()->get('applocale'))" />
                                    <br>
                                    <x-text-input id="username" class="creinput border border-primary block mt-1 w-full" 
                                                type="text" name="username" :value="old('username')" required autofocus />
                                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                                </div>

                                

                                <div class="flex items-center justify-end mt-4">
                                    <x-primary-button class="btn-block fa-lg gradient-custom-2 mb-3">
                                        {{ __('messages.Reset Password', [], session()->get('applocale')) }}
                                    </x-primary-button>
                                </div>
                                <div class="flex items-center justify-end mt-8">
                                    <a href="/login"
                                   style="text-decoration:none" class="">
                                   <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                    {{ __('messages.Return', [], session()->get('applocale')) }} 
                                    </a>
                                </div>
                            </form>

                            </div>
                            <a href="/legal" class="d-block text-center pt-4 pb-4">{{ __("messages.legal_notice_title", [], session()->get('applocale')) }}</a>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <img style="width: 100%; height: 100%; object-fit: cover;" src="/Template/assets/img/password_header.jpg" alt="header">
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
