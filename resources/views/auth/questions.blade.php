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
                                <ul style=" float:right;width:30px; margin:20px" class="navbar-nav ml-auto navbar-center">
                                    <li class="list-inline-item dropdown notification-list hide-phone">
                                        <a class="nav-link dropdown-toggle waves-effect text-white" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" title="Select Language">
                                            <img 
                                            src="{{ asset('Template/flags/' . Session::get('applocale') . '.jpg') }}" 
                                            class="ml-2" height="16" alt=""/>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right language-switch">
                                            @foreach (config('languages') as $lang => $language)
                                                @if ($lang != Session::get('applocale'))
                                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('lang.switch', $lang) }}">
                                                        <img style="width:30px; margin-right:10px" src="{{ asset('Template/flags/' . $language['flag-icon'] . '.jpg') }}" alt="">
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
                                
                           

                            <form method="GET" action="{{ route('password.resetWithSecurityQuestions') }}">
                                @csrf
                                <p class="h5 mb-4">
                                {{ __('messages.Hey',[], session()->get('applocale'))}}
                                {{ $username}},
                                {{ __('messages.please respond to your security questions',[], session()->get('applocale'))}}

                                </p>
                                @if ($errors->has('security_answer'))
                                    <p style="color:red" class="text-red-500 text-sm mt-2">
                                        {{ $errors->first('security_answer') }}
                                    </p>
                                @endif

                                  <!-- Question 1 Input -->
                                  <div>
                                  
                                    <br>
                                    <x-text-input id="username" class="creinput border border-primary block mt-1 w-full" 
                                                type="hidden" name="username" :value="$username" required autofocus />
                                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                                </div>
                                
                                <!-- Question 1 Input -->
                                <div>
                                    <x-input-label for="squestion1" :value="$question1" />
                                    <br>
                                    <x-text-input id="squestion1" class="creinput border border-primary block mt-1 w-full" 
                                                type="text" name="squestion1" :value="old('squestion1')" required autofocus />
                                    <x-input-error :messages="$errors->get('squestion1')" class="mt-2" />
                                </div>

                                <!-- Question 2 Input -->
                                <div class="mt-4">
                                    <x-input-label for="squestion2" :value="$question2" />
                                    <br>
                                    <x-text-input id="squestion2" class="creinput border border-primary block mt-1 w-full" 
                                                type="text" name="squestion2" :value="old('squestion2')" required autofocus />
                                    <x-input-error :messages="$errors->get('squestion2')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <x-primary-button class="btn-block fa-lg gradient-custom-2 mb-3">
                                        {{ __('messages.Reset Password',[], session()->get('applocale')) }}
                                    </x-primary-button>
                                </div>
                            </form>

                            </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <img style="width: 100%; height: 100%; object-fit: cover;" src="/Template/assets/img/confirm_password_header.jpg" alt="header">
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
