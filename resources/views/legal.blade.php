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

                html, body {
                    height: 100%;
                    margin: 0;
                    padding: 0;
                    background-color: #007ACC;
                    background-image: linear-gradient(315deg, #0066B3 0%, #037ade 74%);
                    background-repeat: no-repeat;
                    background-size: cover;
                }
        </style>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="gradient-form mb-4" style="min-height: 100vh;">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="card rounded-3 text-black">
                        <div class="row g-0">
                            <div class="col-lg-12">
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

                                <div class="legal-notice">
                                    <h1 align="center" class="mb-4">{{ __('messages.legal_notice_title', [], session()->get('applocale')) }}</h1>

                                    <p>{{ __('messages.legal_notice_intro', [], session()->get('applocale')) }}</p>

                                    <h4>{{ __('messages.ownership_heading', [], session()->get('applocale')) }}</h4>
                                    <p>
                                        {{ __('messages.university_name', [], session()->get('applocale')) }}<br>
                                        {{ __('messages.university_address_line1', [], session()->get('applocale')) }}<br>
                                        {{ __('messages.university_address_line2', [], session()->get('applocale')) }}<br>
                                        {{ __('messages.university_nif', [], session()->get('applocale')) }}
                                    </p>

                                    <h4>{{ __('messages.intellectual_property_heading', [], session()->get('applocale')) }}</h4>
                                    <p>{{ __('messages.intellectual_property_text', [], session()->get('applocale')) }}</p>

                                    <h4>{{ __('messages.legal_information_heading', [], session()->get('applocale')) }}</h4>
                                    <p>{{ __('messages.legal_information_text', [], session()->get('applocale')) }}</p>

                                    <h4>{{ __('messages.data_protection_heading', [], session()->get('applocale')) }}</h4>
                                    <p>{{ __('messages.data_protection_text', [], session()->get('applocale')) }}</p>

                                    <h4>{{ __('messages.university_responsibility_heading', [], session()->get('applocale')) }}</h4>
                                    <p>{{ __('messages.university_responsibility_text1', [], session()->get('applocale')) }}</p>
                                    <ul>
                                        <li>{{ __('messages.university_responsibility_point1', [], session()->get('applocale')) }}</li>
                                        <li>{{ __('messages.university_responsibility_point2', [], session()->get('applocale')) }}</li>
                                        <li>{{ __('messages.university_responsibility_point3', [], session()->get('applocale')) }}</li>
                                        <li>{{ __('messages.university_responsibility_point4', [], session()->get('applocale')) }}</li>
                                    </ul>

                                    <h4>{{ __('messages.user_responsibility_heading', [], session()->get('applocale')) }}</h4>
                                    <ul>
                                        <li>{{ __('messages.user_responsibility_point1', [], session()->get('applocale')) }}</li>
                                        <li>{{ __('messages.user_responsibility_point2', [], session()->get('applocale')) }}</li>
                                        <li>{{ __('messages.user_responsibility_point3', [], session()->get('applocale')) }}</li>
                                        <li>{{ __('messages.user_responsibility_point4', [], session()->get('applocale')) }}</li>
                                    </ul>

                                    <h4>{{ __('messages.jurisdiction_heading', [], session()->get('applocale')) }}</h4>
                                    <p>{{ __('messages.jurisdiction_text', [], session()->get('applocale')) }}</p>

                                    <h4>{{ __('messages.amendments_heading', [], session()->get('applocale')) }}</h4>
                                    <p>{{ __('messages.amendments_text', [], session()->get('applocale')) }}</p>
                                </div>
                                </div>
                                    <div style="display: flex; justify-content: center" class="mb-4">
                                        <a href="{{ route('login') }}" class="btn btn-primary fa-lg gradient-custom-2 mb-3">
                                            Back to Homepage
                                        </a>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</html>
