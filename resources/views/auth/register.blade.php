<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
                background-color: #037ade;
                background-image: linear-gradient(105deg, #037ade 10%, #037ade 90%);
            }

            .gradient-custom-2:hover {
                background-color: #03e5b7;
                background-image: linear-gradient(315deg, #03e5b7 0%, #037ade 90%);
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

            /* Add this to make all text in the form smaller */
            .card-body {
                font-size: 0.85rem; /* Adjust this value as needed for smaller text */
            }

            .creinput {
                width: 100%;
                border-radius: 10px;
                height: 40px;
                font-size: 0.85rem; /* Ensure input text is also smaller */
            }

            .colorRed{
                color: red;
            }
        </style>
    </head>
    <body class="font-sans antialiased " style="background-color: #03e5b7; background-image: linear-gradient(315deg, #03e5b7 0%, #037ade 74%);">
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
                                        <img src="/Template/assets/img/logo.png" style="width: 100px;" alt="logo">
                                    </div>
                                    <form class="mt-2" method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <!-- Name -->
                                        <div>
                                            <x-input-label for="name" :value="__('messages.Name', [], session()->get('applocale'))" />
                                            <br>
                                            <x-text-input id="name" class="creinput border border-primary block mt-1 w-full" 
                                                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                                            <x-input-error :messages="$errors->get('name')" class="mt-2 colorRed" />
                                        </div>

                                        <!-- Username -->
                                        <div class="mt-4">
                                            <x-input-label for="username" :value="__('messages.Username', [], session()->get('applocale'))" />
                                            <br>
                                            <x-text-input id="username" class="creinput border border-primary block mt-1 w-full" 
                                                        type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
                                            <x-input-error :messages="$errors->get('username')" class="mt-2 colorRed" />
                                        </div>

                                        <!-- Password -->
                                        <div class="mt-4">
                                            <x-input-label for="password" :value="__('messages.Password', [], session()->get('applocale'))" />
                                            <br>
                                            <x-text-input id="password" class="creinput border border-primary block mt-1 w-full"
                                                        type="password" name="password" required autocomplete="new-password" />
                                            <x-input-error :messages="$errors->get('password')" class="mt-2 colorRed" />
                                        </div>

                                        <!-- Confirm Password -->
                                        <div  class="mt-4 mb-4">
                                            <x-input-label for="password_confirmation" :value="__('messages.Confirm Password', [], session()->get('applocale'))" />
                                            <br>
                                            <x-text-input id="password_confirmation" class="creinput border border-primary block mt-1 w-full"
                                                        type="password" name="password_confirmation" required autocomplete="new-password" />
                                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 colorRed" />
                                        </div>

                                        <!-- Security Question 1 -->
                                        <div class="mt-4">
                                            <x-input-label for="security_question_1" :value="__('messages.Security Question', [], session()->get('applocale')) . ' 1'" />
                                            <br>
                                            <select id="security_question_1" name="security_question_1" class="creinput border border-primary block mt-1 w-full" required>
                                                <option value="">{{ __('messages.Select a question', [], session()->get('applocale'))}}</option>
                                                @foreach($questions->slice(0, 8) as $q)
                                                <option value="q{{ $q->qid }}">{{ __('messages.q' . $q->qid , [], session()->get('applocale'))}}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('security_question_1')" class="mt-2 colorRed" />

                                            <x-input-label for="security_answer_1" :value="__('messages.Answer', [], session()->get('applocale')) . ' 1'" class="mt-2" />
                                            <br>
                                            <x-text-input id="security_answer_1" class="creinput border border-primary block mt-1 w-full"
                                                        type="text" name="security_answer_1" required />
                                            <x-input-error :messages="$errors->get('security_answer_1')" class="mt-2 colorRed" />
                                        </div>

                                        <!-- Security Question 2 -->
                                        <div class="mt-4">
                                            <x-input-label for="security_question_2" :value="__('messages.Security Question', [], session()->get('applocale')) . ' 2'" />
                                            <br>
                                            <select id="security_question_2" name="security_question_2" class="creinput border border-primary block mt-1 w-full" required>
                                                <option value="">{{ __('messages.Select a question', [], session()->get('applocale'))}}</option>
                                                @foreach($questions->slice(8, 16) as $q)
                                                <option value="q{{ $q->qid }}">{{ __('messages.q' . $q->qid , [], session()->get('applocale'))}}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('security_question_2', [], session()->get('applocale'))" class="mt-2" />

                                            <x-input-label for="security_answer_2" :value="__('messages.Answer', [], session()->get('applocale')) . ' 2'" class="mt-2" />
                                            <br>
                                            <x-text-input id="security_answer_2" class="creinput border border-primary block mt-1 w-full"
                                                        type="text" name="security_answer_2" required />
                                            <x-input-error :messages="$errors->get('security_answer_2')" class="mt-2 colorRed" />
                                        </div>
                                         <!-- Legal Notice Agreement -->
                                         <div class="mt-4">
                                            <label class="inline-flex items-center">
                                                <input type="checkbox" name="legal_notice" required class="form-checkbox text-indigo-600 border border-primary">
                                                <span class="ml-4 text-sm text-gray-600">
                                                    {{ __('messages.I have read and accept the', [], session()->get('applocale')) }}
                                                    <a href="/legal" target="_blank" class="underline text-blue-600 hover:text-blue-800">
                                                        {{ __('messages.legal_notice_title', [], session()->get('applocale')) }}
                                                    </a>
                                                </span>
                                            </label>
                                            <x-input-error :messages="$errors->get('legal_notice')" class="mt-2 colorRed" />
                                        </div>
                                        <div  class="flex items-center justify-end mt-4">
                                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                                                {{ __('messages.Already registered?', [], session()->get('applocale')) }}
                                            </a>

                                            <x-primary-button class="ms-3 btn-block fa-lg gradient-custom-2 mb-3">
                                                {{ __('messages.Register', [], session()->get('applocale')) }}
                                            </x-primary-button>
                                        </div>
                                       
                                    </form>
                                </div>
                                <a href="/legal" class="d-block text-center pt-4 pb-4">{{ __("messages.legal_notice_title", [], session()->get('applocale')) }}</a>
                            </div>
                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <img style="width: 100%; height: 100%; object-fit: cover;" src="/Template/assets/img/register_header.jpg" alt="header">
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
