<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Demhaic') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Include Bootstrap CSS in your layout if not already added -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
        <script src="https://unpkg.com/alpinejs@3.0.6" defer></script>
        <!-- Include Bootstrap CSS in your layout if not already added -->
        <!-- Add font awesome for the icons -->
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <!-- Add Bootstrap JS (optional for better responsiveness) -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Add font awesome for the icons -->
        <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
        <!-- Add Bootstrap JS (optional for better responsiveness) -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
        <style>
            .openmain{

                padding-left:200px;
            }
            .closedmain{

                padding-left:80px;
            }
            .liactive{
                background-color:#34495e;
                width:100%;
            }
            .bg-yellow{
                background-color: #FFC107;
            }
            .bg-light-blue{
                background-color: #6CA8F1;
            }
            .bg-green{
                background-color: #00b389;
                color:#ffff;
            }

            .bg-light-green{
                
                background-color: #2ecc71;
                color:#ffff;
            }

            .bg-light-green:hover{ color:#ffff;}

            .bg-red{
                background-color: #D9534F;
                color:#ffff;
            }

            .bg-green:hover{
                background-color: #008f74;
                color:#ffff;
            }

            .bg-red:hover{
                background-color: #C13C39;
                color:#ffff;
            }

            .c-yellow{
                color: #FFC107;
            }
            .c-light-blue{
                color: #6CA8F1;
            }
            .c-green{
                color: #28A745;
            }

            .c-red{
                color: #D9534F;
            }

            .c-grey{
                color: #36454F;
            }

            .c-black{
                color: #000000;
            }

            .c-blue{
                color: #0056b3;
            }

            .c-white{
                color: #ffffff;
            }

            .b-yellow{
                border:  1px solid #FFC107;
            }
            .b-light-blue{
                border:  1px solid #6CA8F1;
            }
            .b-green{
                border:  1px solid #28A745;
            }

            .b-red{
                border: 1px solid #D9534F;
            }

            .b-grey{
                border: 1px solid #D3D3D3;
            }

          
            .b-bottom-grey{
                border-bottom: 2px solid #D3D3D3 !important;
            }

            .b-bottom-yellow{
                border-bottom:  2px solid #FFC107 !important;
            }
            .b-bottom-light-blue{
                border-bottom:  2px solid #6CA8F1 !important;
            }
            .b-bottom-green{
                border-bottom:  2px solid #28A745 !important;
            }

            .b-bottom-red{
                border-bottom: 2px solid #D9534F !important;
            }

            .horizontal-list {
                list-style-type: none; /* Remove default bullets */
                padding: 0; /* Remove default padding */
                display: flex; /* Use flexbox to arrange items in a row */
                gap: 20px; /* Optional: Add space between the items */
                justify-content: center; /* Center items horizontally */
            }

            .horizontal-list li {
                display: flex; /* Use flexbox for each list item */
                flex-direction: column; /* Arrange items vertically */
                align-items: center; /* Center items horizontally */
            }

            .rating-label {
                margin-bottom: 5px; /* Space between the label and the radio button */
            }
            .text-center {
                text-align: center;
                width: 100%; /* Ensure it takes full width */
            }

            .nodec:hover{
                text-decoration:none;
                color:#ffff;
            }

        
        
            .horizontal-list {
                list-style-type: none;
                padding: 0;
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                justify-content: center;
            }
            @media (max-width: 768px) {
                .horizontal-list {
                    flex-direction: column;
                    align-items: center;
                }
            }
            .modal-body {
                padding: 1rem;
            }
            @media (min-width: 768px) {
                .modal-body {
                    padding: 2rem 3rem;
                }
            }
            .text-center {
                text-align: center;
                width: 100%;
            }
            .w-full {
                width: 100%;
            }

            @media (max-width: 576px) {
             ul.horizontal-list {
                display: flex !important;
                flex-direction: row;
                flex-wrap: nowrap !important;
                align-items: center;
                padding: 0;
                margin: 0;
                list-style: none;
              }
              ul.horizontal-list li {
                flex: 0 0 auto;
                margin-right: 8px;
                font-size: 7pt;
              }
            }
        </style>
        @yield('style')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div  class="max-w-10xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            <!-- Page Content -->
            <main>
                <!-- Alpine.js for toggle functionality -->
                <div x-data="{ isSidebarOpen: window.innerWidth < 768 ? false : true }" class="d-flex flex-column flex-md-row ">
                    <div >
                    @include('layouts.leftmenu')
                    </div>
                    <!-- Main content -->
                    <div  :class="isSidebarOpen ? 'openmain' : 'closedmain'" class="flex-1 transition-all duration-300" style="margin-top:60px">
                         <!-- Header outside the main content but inside the flex container -->
                        <header class="bg-white shadow">
                            <div  class="max-w-9xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                                <div style="padding-left:30px">
                                @yield('headertitle')
                                </div>

                                <button id="openLeftMenuButton" @click="isSidebarOpen = !isSidebarOpen" class="d-none btn btn-outline-secondary d-md-none mb-2">
                                    ☰ {{ __('messages.Menu') }}
                                </button>
                                <!-- Flex container for the message and button on the right -->
                                <div id="addDiaryDiv" class="flex items-center space-x-4">
                                    <!--<p>{{ $initialForm}}</p>-->
                                 
                                    @if($initialForm && !$isCompleted)

                                    <p class="d-none d-md-block c-red h6 m-0 mr-4"><i class="fa fa-exclamation-triangle c-red mr-2"></i>{{ __('messages.Please click on the button to complete your initial form !', [], session()->get('applocale')) }}</p>
                                    <a data-toggle="modal" data-target="#initialModal" class="d-none d-md-block ml-4 btn bg-danger text-white pr-4 pl-4">
                                       
                                     {{ __('messages.Initial form', [], session()->get('applocale')) }}
                                       
                                    </a>
                                    @else
                                        @if($diaryForm && !$hasEntryToday)
                                        <p class="c-red h6 m-0 mr-4 d-none d-md-block"><i class="fa fa-exclamation-triangle c-red mr-2"></i>{{ __("messages.Don't forget to add your diary for today", [], session()->get('applocale'))}}</p>
                                     
                                        <button data-toggle="modal" data-target="#diaryModal" class="d-none d-md-block btn bg-green text-white">
                                            {{ __('messages.Add your diary', [], session()->get('applocale')) }} +
                                        </button>

                                      
                                        @endif
                                    @endif
                                    <button data-toggle="modal" data-target="#weeklyModal" class="d-none d-md-block btn ml-2 btn-info text-white">
                                        {{ __('messages.Add your reflection', [], session()->get('applocale')) }} +
                                    </button>
                                 
                                   
                                </div>
                                
                                <!-- 
                                <div class="flex items-center space-x-4">
                                    <p class="c-green h6 m-0 mr-4"><i class="fa fa-check-circle c-green mr-2"></i> You’ve succesfully added your diary entry for today</p>
                                </div>-->
                            </div>

                            <div class="ml-4 container d-block d-md-none">    
                            <div id="addDiaryDiv" class="flex items-center space-x-4 row">
                                    <!--<p>{{ $initialForm}}</p>-->
                                 
                                    @if($initialForm && !$isCompleted)

                                    <p class="c-red h6 mb-2 m-0 mr-4"><i class="fa fa-exclamation-triangle c-red mr-2"></i>{{ __('messages.Please click on the button to complete your initial form !', [], session()->get('applocale')) }}</p>
                                    <a data-toggle="modal" data-target="#initialModal" class="ml-4 btn bg-danger text-white pr-4 pl-4">
                                       
                                     {{ __('messages.Initial form', [], session()->get('applocale')) }}
                                       
                                    </a>
                                    @else
                                        @if($diaryForm && !$hasEntryToday)
                                        <p class="c-red h6 mb-2 m-0 mr-4"><i class="fa fa-exclamation-triangle c-red mr-2"></i>{{ __("messages.Don't forget to add your diary for today", [], session()->get('applocale'))}}</p>
                                     
                                        <button data-toggle="modal" data-target="#diaryModal" class="mb-2 btn bg-green text-white">
                                            {{ __('messages.Add your diary', [], session()->get('applocale')) }} +
                                        </button>

                                      
                                        @endif
                                    @endif
                                    <button data-toggle="modal" data-target="#weeklyModal" class="btn mb-2  ml-2 btn-info text-white">
                                        {{ __('messages.Add your reflection', [], session()->get('applocale')) }} +
                                    </button>
                                 
                                   
                                </div>
                                 </div> 

                         
                            <!-- Modal Diary Structure -->
                            <div class="modal fade mt-4" id="diaryModal" tabindex="-1" role="dialog" aria-labelledby="diaryModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title h4 text-center pt-2 pb-2" id="diaryModalLabel">{{ __('messages.Please complete the following form', [], session()->get('applocale')) }}</h3>
                                            <button id="closeDiaryModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body container-fluid px-3 px-md-5">
                                            <form id="diaryForm">
                                                @csrf

                                                <!-- Progress Bar -->
                                                <div class="mb-4">
                                                    <div class="progress">
                                                        <div id="diaryProgressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                                    </div>
                                                </div>

                                                <!-- Date Input Field -->
                                                <div class="mb-4">
                                                    <label for="entryDate" class="mb-4">{{ __('messages.Entry Date', [], session()->get('applocale'))}}</label>
                                                    <input type="date" id="entryDate" name="Entry Date" value="{{ now()->format('Y-m-d') }}" required>
                                                </div>

                                                @if($diaryFormQuestions)
                                                @foreach($diaryFormQuestions as $question)
                                                    @php
                                                        $questionType = $question->type;
                                                        $questionId = $question->id;
                                                        $questionText = $question->question;
                                                    @endphp

                                                    <!-- Question Step -->
                                                    <div class="diaryQuestion-step">
                                                        <label for="question{{ $questionId }}" class="mb-4">{{ $questionText }}</label>
                                                        
                                                        @if($questionType == 'scale')
                                                            <!-- Scale Input (Radio Buttons) -->
                                                            <ul class="horizontal-list mb-4">
                                                                <li class="">{{ $question->scalemin }}</li>
                                                                @for($i = 1; $i <= $question->scale; $i++)
                                                                    <li>
                                                                        <label for="question{{ $questionId }}_{{$i}}" class="rating-label">{{$i}}</label>
                                                                        <input type="radio" id="diaryQuestion{{ $questionId }}_{{$i}}" name="{{ $questionText }}" value="{{$i}}" required>
                                                                    </li>
                                                                @endfor
                                                                <li class="">{{ $question->scalemax }}</li>
                                                            </ul>
                                                        @elseif($questionType == 'number')
                                                            <!-- Number Input -->
                                                            <input type="number" id="diaryQuestion{{ $questionId }}" name="{{ $questionText }}" required
                                                            placeholder="{{ $question->placeholder ?? 'Enter value' }}" max="20"
                                                            pattern="[0-9]*"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                        @elseif($questionType == 'yes_no')
                                                            <!-- Yes/No Radio Buttons -->
                                                            <ul class="horizontal-list mb-4">
                                                                <li class="h6">{{ __('messages.Yes', [], session()->get('applocale'))}}</li>
                                                                <li>
                                                                    <input class="mt-1" type="radio" id="diaryQuestion{{ $questionId }}_yes" name="{{ $questionText }}" value="yes" required>
                                                                </li>
                                                                <li class="h6">{{ __('messages.No', [], session()->get('applocale'))}}</li>
                                                                <li>
                                                                    <input class="mt-1" type="radio" id="diaryQuestion{{ $questionId }}_no" name="{{ $questionText }}" value="no" required>
                                                                </li>
                                                            </ul>
                                                        @elseif($questionType == 'large_text')
                                                        
                                                            <!-- Textarea Input -->
                                                            <textarea class="w-full" id="diaryQuestion{{ $questionId }}" name="{{ $questionText }}" rows="{{ $question->rows ?? '4' }}" placeholder="{{ $question->placeholder ?? 'Write your response here' }}"></textarea>
                                                        @elseif($questionType == 'text')
                                                            <!-- Text Input -->
                                                            <input type="text" id="diaryQuestion{{ $questionId }}" name="{{ $questionText }}" required placeholder="{{ $question->placeholder ?? 'Enter value' }}">

                                                        @elseif($questionType == 'checkboxes')
                                                            <!-- Dynamic Checkboxes -->
                                                            @if($question->options && is_array($question->options))
                                                                <ul class="checkbox-list mb-4">
                                                                    @foreach($question->options as $option)
                                                                        <li>
                                                                            <label>
                                                                                <input type="checkbox" name="{{ $questionText }}" value="{{ $option }}">
                                                                                {{ $option }}
                                                                            </label>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif

                                                            @elseif($questionType == 'multiple_choice')
                                                            <!-- Dynamic Multiple Choice (Checkboxes) -->
                                                            @if($question->options && is_array($question->options))
                                                                <ul class="radio-list mb-4">
                                                                    @foreach($question->options as $option)
                                                                        <li>
                                                                            <label>
                                                                                <input type="checkbox" 
                                                                                    id="diaryQuestion{{ $questionId }}_{{ Str::slug($option) }}" 
                                                                                    name="{{ $questionText }}[]" 
                                                                                    value="{{ $option }}">
                                                                                {{ $option }}
                                                                            </label>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        @endif

                                                        
                                                    </div>
                                                @endforeach
                                                @endif


                                                <!-- Navigation Buttons -->
                                                <div class="mt-4 d-flex flex-wrap justify-content-between gap-2">
                                                    <button type="button" id="diaryPrevBtn" class="btn btn-info">{{ __('messages.Previous', [], session()->get('applocale'))}}</button>
                                                    <button type="button" id="diaryNextBtn" class="btn btn-info">{{ __('messages.Next', [], session()->get('applocale'))}}</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.Cancel', [], session()->get('applocale'))}}</button>
                                            <button type="button" class="btn btn-success initial" id="diary-save-btn" style="display: none;">{{ __('messages.Save All Responses', [], session()->get('applocale'))}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Weekly Structure -->
                            <div class="modal fade mt-4" id="weeklyModal" tabindex="-1" role="dialog" aria-labelledby="weeklyModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title h4 text-center pt-2 pb-2" id="weeklyModalLabel">{{ __('messages.Please complete the following form', [], session()->get('applocale')) }}</h3>
                                            <button id="closeWeeklyModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body container-fluid px-3 px-md-5">
                                            <form id="weeklyForm">
                                                @csrf

                                                <!-- Progress Bar -->
                                                <div class="mb-4">
                                                    <div class="progress">
                                                        <div id="weeklyProgressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                                    </div>
                                                </div>

                                                <!-- Date Input Field -->
                                                <div class="d-flex gap-3 mb-4">
                                                    <!-- Starting Date -->
                                                    <div>
                                                        <label for="entryDateStart" class="mb-2">{{ __('messages.Starting date', [], session()->get('applocale'))}}</label>
                                                        <input type="date" id="entryDateStart" name="starting_date" class="form-control" value="{{ now()->subWeek()->format('Y-m-d') }}" required>
                                                        
                                                    </div>

                                                    <!-- Finishing Date -->
                                                    <div class="ml-4">
                                                        <label for="entryDateFinish" class="mb-2">{{ __('messages.Finishing date', [], session()->get('applocale'))}}</label>
                                                        <input type="date" id="entryDateFinish" name="finishing_date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
                                                    </div>
                                                </div>


                                                @if($weeklyFormQuestions)
                                                @foreach($weeklyFormQuestions as $question)
                                                    @php
                                                        $questionType = $question->type;
                                                        $questionId = $question->id;
                                                        $questionText = $question->question;
                                                    @endphp

                                                    <!-- Question Step -->
                                                    <div class="weeklyQuestion-step">
                                                        <label for="question{{ $questionId }}" class="mb-4">{{ $questionText }}</label>
                                                        
                                                        @if($questionType == 'scale')
                                                            <!-- Scale Input (Radio Buttons) -->
                                                            <ul class="horizontal-list mb-4">
                                                                <li class="">{{ $question->scalemin }}</li>
                                                                @for($i = 1; $i <= $question->scale; $i++)
                                                                    <li>
                                                                        <label for="question{{ $questionId }}_{{$i}}" class="rating-label">{{$i}}</label>
                                                                        <input type="radio" id="weeklyQuestion{{ $questionId }}_{{$i}}" name="{{ $questionText }}" value="{{$i}}" required>
                                                                    </li>
                                                                @endfor
                                                                <li class="">{{ $question->scalemax }}</li>
                                                            </ul>
                                                        @elseif($questionType == 'number')
                                                            <!-- Number Input -->
                                                            <input type="number" id="weeklyQuestion{{ $questionId }}" name="{{ $questionText }}" required
                                                            placeholder="{{ $question->placeholder ?? 'Enter value' }}"
                                                            pattern="[0-9]*"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                                        @elseif($questionType == 'yes_no')
                                                            <!-- Yes/No Radio Buttons -->
                                                            <ul class="horizontal-list mb-4">
                                                                <li class="h6">{{ __('messages.Yes', [], session()->get('applocale'))}}</li>
                                                                <li>
                                                                    <input class="mt-1" type="radio" id="weeklyQuestion{{ $questionId }}_yes" name="{{ $questionText }}" value="yes" required>
                                                                </li>
                                                                <li class="h6">{{ __('messages.No', [], session()->get('applocale'))}}</li>
                                                                <li>
                                                                    <input class="mt-1" type="radio" id="weeklyQuestion{{ $questionId }}_no" name="{{ $questionText }}" value="no" required>
                                                                </li>
                                                            </ul>
                                                        @elseif($questionType == 'large_text')
                                                        
                                                            <!-- Textarea Input -->
                                                            <textarea class="w-full" id="weeklyQuestion{{ $questionId }}" name="{{ $questionText }}" rows="{{ $question->rows ?? '4' }}" placeholder="{{ $question->placeholder ?? 'Write your response here' }}"></textarea>
                                                        @elseif($questionType == 'text')
                                                            <!-- Text Input -->
                                                            <input type="text" id="weeklyQuestion{{ $questionId }}" name="{{ $questionText }}" required placeholder="{{ $question->placeholder ?? 'Enter value' }}">

                                                        @elseif($questionType == 'checkboxes')
                                                            <!-- Dynamic Checkboxes -->
                                                            @if($question->options && is_array($question->options))
                                                                <ul class="checkbox-list mb-4">
                                                                    @foreach($question->options as $option)
                                                                        <li>
                                                                            <label>
                                                                                <input type="checkbox" name="{{ $questionText }}" value="{{ $option }}">
                                                                                {{ $option }}
                                                                            </label>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif

                                                            @elseif($questionType == 'multiple_choice')
                                                            <!-- Dynamic Multiple Choice (Checkboxes) -->
                                                            @if($question->options && is_array($question->options))
                                                                <ul class="radio-list mb-4">
                                                                    @foreach($question->options as $option)
                                                                        <li>
                                                                            <label>
                                                                                <input type="checkbox" 
                                                                                    id="weeklyQuestion{{ $questionId }}_{{ Str::slug($option) }}" 
                                                                                    name="{{ $questionText }}[]" 
                                                                                    value="{{ $option }}">
                                                                                {{ $option }}
                                                                            </label>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        @endif

                                                        
                                                    </div>
                                                @endforeach
                                                @endif


                                                <!-- Navigation Buttons -->
                                                <div class="mt-4 d-flex flex-wrap justify-content-between gap-2">
                                                    <button type="button" id="weeklyPrevBtn" class="btn btn-info">{{ __('messages.Previous', [], session()->get('applocale'))}}</button>
                                                    <button type="button" id="weeklyNextBtn" class="btn btn-info">{{ __('messages.Next', [], session()->get('applocale'))}}</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.Cancel', [], session()->get('applocale'))}}</button>
                                            <button type="button" class="btn btn-success initial" id="weekly-save-btn" style="display: none;">{{ __('messages.Save All Responses', [], session()->get('applocale'))}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal INITIAL Structure -->
                            <div class="modal fade mt-4" id="initialModal" tabindex="-1" role="dialog" aria-labelledby="initialModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title h4 text-center pt-2 pb-2" id="initialModalLabel">{{ __('messages.Please complete the following form', [], session()->get('applocale'))}}</h3>
                                            <button id="closeInitialModal" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body container-fluid px-3 px-md-5">
                                            <form id="initialForm">
                                                @csrf

                                                <!-- Progress Bar -->
                                                <div class="mb-4">
                                                    <div class="progress">
                                                        <div id="initialProgressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                                    </div>
                                                </div>
                                                @if($initialFormQuestions)
                                                @foreach($initialFormQuestions as $question)
                                                    @php
                                                        $questionType = $question->type;
                                                        $questionId = $question->id;
                                                        $questionText = $question->question;
                                                    @endphp

                                                    <!-- Question Step -->
                                                    <div class="initialQuestion-step">
                                                        <label for="initialQuestion{{ $questionId }}" class="mb-4">{{ $questionText }}</label>
                                                        
                                                        @if($questionType == 'scale')
                                                            <!-- Scale Input (Radio Buttons) -->
                                                            <ul class="horizontal-list mb-4">
                                                                <li class="c-red">{{ $question->scalemin }}</li>
                                                                @for($i = 1; $i <= $question->scale; $i++)
                                                                    <li>
                                                                        <label for="question{{ $questionId }}_{{$i}}" class="rating-label">{{$i}}</label>
                                                                        <input type="radio" id="initialQuestion{{ $questionId }}_{{$i}}"  name="{{ $questionText }}" value="{{$i}}" required>
                                                                    </li>
                                                                @endfor
                                                                <li class="c-green">{{ $question->scalemax }}</li>
                                                            </ul>
                                                        @elseif($questionType == 'number')
                                                            <!-- Number Input -->
                                                            <input type="number" id="initialQuestion{{ $questionId }}"  name="{{ $questionText }}" required placeholder="{{ $question->placeholder ?? 'Enter value' }}">
                                                        @elseif($questionType == 'yes_no')
                                                            <!-- Yes/No Radio Buttons -->
                                                            <ul class="horizontal-list mb-4">
                                                                <li class="c-green h6">{{ __('messages.Yes', [], session()->get('applocale'))}}</li>
                                                                <li>
                                                                    <input class="mt-1" type="radio" id="initialQuestion{{ $questionId }}_yes"  name="{{ $questionText }}" value="yes" required>
                                                                </li>
                                                                <li class="c-red h6">{{ __('messages.No', [], session()->get('applocale'))}}</li>
                                                                <li>
                                                                    <input class="mt-1" type="radio" id="initialQuestion{{ $questionId }}_no"  name="{{ $questionText }}" value="no" required>
                                                                </li>
                                                            </ul>
                                                        @elseif($questionType == 'large_text')
                                                            <!-- Textarea Input -->
                                                            <textarea class="w-full" id="initialQuestion{{ $questionId }}"  name="{{ $questionText }}" rows="{{ $question->rows ?? '4' }}"  placeholder="{{ $question->placeholder ?? 'Write your response here' }}"></textarea>
                                                        @elseif($questionType == 'text')
                                                            <!-- Text Input -->
                                                            <input type="text" id="initialQuestion{{ $questionId }}"  name="{{ $questionText }}" required placeholder="{{ $question->placeholder ?? 'Enter value' }}">

                                                        @elseif($questionType == 'checkboxes')
                                                            <!-- Dynamic Checkboxes -->
                                                            @if($question->options && is_array($question->options))
                                                                <ul class="checkbox-list mb-4">
                                                                    @foreach($question->options as $option)
                                                                        <li>
                                                                            <label>
                                                                                <input type="checkbox" name="initialQuestion{{ $questionId }}[]" value="{{ $option }}">
                                                                                {{ $option }}
                                                                            </label>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif

                                                        @elseif($questionType == 'multiple_choice')
                                                            <!-- Dynamic Multiple Choice (Radio Buttons) -->
                                                            @if($question->options && is_array($question->options))
                                                                <ul class="radio-list mb-4">
                                                                    @foreach($question->options as $option)
                                                                        <li>
                                                                            <label>
                                                                                <input type="radio" id="initialQuestion{{ $questionId }}_{{ $loop->index }}" name="initialQuestion{{ $questionId }}" value="{{ $option }}" required>
                                                                                {{ $option }}
                                                                            </label>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                        @endif
                                                    </div>
                                                @endforeach
                                                @endif


                                                <!-- Navigation Buttons -->
                                                <div class="mt-4 d-flex flex-wrap justify-content-between gap-2">
                                                    <button type="button" id="initialPrevBtn" class="btn btn-info">{{ __('messages.Previous', [], session()->get('applocale'))}}</button>
                                                    <button type="button" id="initialNextBtn" class="btn btn-info">{{ __('messages.Next', [], session()->get('applocale'))}}</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.Cancel', [], session()->get('applocale'))}}</button>
                                            <button type="button" class="btn btn-success initial" id="initial-save-btn" style="display: none;">{{ __('messages.Save All Responses', [], session()->get('applocale'))}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </header>
                        <!-- Main content -->
                        <main  class="py-6 px-6">
                            <div id="successResponses" class="d-none alert alert-success">
                                <p>{{ __('messages.Response are successfully saved !', [], session()->get('applocale'))}}</p>
                            </div>
                            @yield('maincontent')
                        </main>
                    </div>
                </div>
            </main>
        </div>
    </body>

    @yield('scripts')

    <script>

        const responses = {};
        const initialForm = document.getElementById('initialForm');
        const initialSteps = document.querySelectorAll('.initialQuestion-step');
        const initialNextBtn = document.getElementById('initialNextBtn');
        const initialPrevBtn = document.getElementById('initialPrevBtn');
        const initialProgressBar = document.getElementById('initialProgressBar');
        const initialSaveBtn = document.getElementById('initial-save-btn');

        let currentStep = 0;

        // Show the current step
        function showStep(step) {
            initialSteps.forEach((s, index) => {
                s.style.display = (index === step) ? 'block' : 'none';
            });

            // Update progress
            const progressPercent = ((step + 1) / initialSteps.length) * 100;
            initialProgressBar.style.width = progressPercent + '%';
            initialProgressBar.setAttribute('aria-valuenow', progressPercent);
            initialProgressBar.innerText = Math.round(progressPercent) + '%';

            // Show/hide buttons
            initialPrevBtn.disabled = (step === 0);
            initialNextBtn.style.display = (step === initialSteps.length - 1) ? 'none' : 'inline-block';
            initialSaveBtn.style.display = (step === initialSteps.length - 1) ? 'inline-block' : 'none';
        }

        // Next button functionality
        initialNextBtn.addEventListener('click', () => {
            if (currentStep < initialSteps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });

        // Previous button functionality
        initialPrevBtn.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });

        // Save responses as JSON
        initialSaveBtn.addEventListener('click', () => {
           
                $('#initialModal').modal('hide'); // Hide the modal
                $('.modal-backdrop').remove(); // Remove the backdrop manually
                $('body').removeClass('modal-open'); // Remove the 'modal-open' class from the <body>
                $('body').css('padding-right', ''); // Reset body padding, if necessary


                const formData = new FormData(initialForm);
                const responses = {};
                const dformId = <?php 

               echo $initialForm ? $initialForm->id : 'null'; 
                ?>;
                formData.forEach((value, key) => {
                    if (value !== null && value !== undefined) {
                        responses[key] = value;
                    } else {
                        console.warn(`Value for key '${key}' is null or undefined.`);
                    }
                });

                // Convert to JSON
                const jsonResponses = JSON.stringify(responses);

                console.log('Save button has the "initial" class. Proceeding with initial save logic...');
                fetch('/entries', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ dformId: dformId, responses }),
                })
                .then(response => {
                    if (!response.ok) {
                        return Promise.reject('Failed to save');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Initial form saved successfully:', data);
                   
                   
                })
                .catch(error => {
                    console.error('Error saving initial form:', error);
                    // Optionally show an error message to the user
                });

                // Optionally close modal after saving
                //$('#initialModal').modal('hide');
                //$('#closeInitialModal').click();
                $('#successResponses').removeClass('d-none'); // Remove the class
                setTimeout(function() {
                    $('#successResponses').addClass('d-none'); // Add the class back after 2 seconds
                     location.reload();
                  
                }, 3000);
        });

        // Initialize the first step
        showStep(currentStep);

        const diaryForm = document.getElementById('diaryForm');
        const diarySteps = document.querySelectorAll('.diaryQuestion-step');
        const diaryNextBtn = document.getElementById('diaryNextBtn');
        const diaryPrevBtn = document.getElementById('diaryPrevBtn');
        const diaryProgressBar = document.getElementById('diaryProgressBar');
        const diarySaveBtn = document.getElementById('diary-save-btn');

        let currentDiaryStep = 0;

        // Show the current step
        function showDiaryStep(step) {
            diarySteps.forEach((s, index) => {
                s.style.display = (index === step) ? 'block' : 'none';
            });

            // Update progress
            const progressPercent = ((step + 1) / diarySteps.length) * 100;
            diaryProgressBar.style.width = progressPercent + '%';
            diaryProgressBar.setAttribute('aria-valuenow', progressPercent);
            diaryProgressBar.innerText = Math.round(progressPercent) + '%';

            // Show/hide buttons
            diaryPrevBtn.disabled = (step === 0);
            diaryNextBtn.style.display = (step === diarySteps.length - 1) ? 'none' : 'inline-block';
            diarySaveBtn.style.display = (step === diarySteps.length - 1) ? 'inline-block' : 'none';
        }

        // Next button functionality
        diaryNextBtn.addEventListener('click', () => {
            if (currentDiaryStep < diarySteps.length - 1) {
                currentDiaryStep++;
                showDiaryStep(currentDiaryStep);
            }
        });

        // Previous button functionality
        diaryPrevBtn.addEventListener('click', () => {
            if (currentDiaryStep > 0) {
                currentDiaryStep--;
                showDiaryStep(currentDiaryStep);
            }
        });

        // Save responses as JSON
        diarySaveBtn.addEventListener('click', () => {

                $('#diaryModal').modal('hide'); // Hide the modal
                $('.modal-backdrop').remove(); // Remove the backdrop manually
                $('body').removeClass('modal-open'); // Remove the 'modal-open' class from the <body>
                $('body').css('padding-right', ''); // Reset body padding, if necessary

                $('#addDiaryDiv').addClass('d-none');

                //$('#closeDiaryModal').click();
                const formData = new FormData(diaryForm);
                const responses = {};
                const dformId = <?php echo $diaryForm->id ?>;
                formData.forEach((value, key) => {
                     // If the key already exists, convert or append to an array
                    if (responses.hasOwnProperty(key)) {
                        if (Array.isArray(responses[key])) {
                            responses[key].push(value);
                        } else {
                            responses[key] = [responses[key], value];
                        }
                    } else {
                        responses[key] = value;
                    }
                });
                console.log(formData);

                // Convert to JSON
                const jsonResponses = JSON.stringify(responses);
                console.log(responses);

                console.log('Save button has the "diary" class. Proceeding with diary save logic...');
                fetch('/entries', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({ dformId: dformId, responses }),
                })
                .then(response => {
                    if (!response.ok) {
                        return Promise.reject('Failed to save');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Diary form saved successfully:', data);
                   
                })
                .catch(error => {
                    console.error('Error saving diary form:', error);
                    // Optionally show an error message to the user
                });

                // Optionally close modal after saving
                //$('#diaryModal').modal('hide');
            
                $('#successResponses').removeClass('d-none'); // Remove the class
                setTimeout(function() {
                    $('#successResponses').addClass('d-none'); // Add the class back after 2 seconds
                    //location.reload(); // Reload the page
                }, 3000);
            
        });

        // Initialize the first step
        showDiaryStep(currentDiaryStep);


    </script>

    <script>
        const weeklyForm = document.getElementById('weeklyForm');
        const weeklySteps = document.querySelectorAll('.weeklyQuestion-step');
        const weeklyNextBtn = document.getElementById('weeklyNextBtn');
        const weeklyPrevBtn = document.getElementById('weeklyPrevBtn');
        const weeklyProgressBar = document.getElementById('weeklyProgressBar');
        const weeklySaveBtn = document.getElementById('weekly-save-btn');

        let currentWeeklyStep = 0;

        // Show the current step
        function showWeeklyStep(step) {
            weeklySteps.forEach((s, index) => {
                s.style.display = (index === step) ? 'block' : 'none';
            });

            // Update progress
            const progressPercent = ((step + 1) / weeklySteps.length) * 100;
            weeklyProgressBar.style.width = progressPercent + '%';
            weeklyProgressBar.setAttribute('aria-valuenow', progressPercent);
            weeklyProgressBar.innerText = Math.round(progressPercent) + '%';

            // Show/hide buttons
            weeklyPrevBtn.disabled = (step === 0);
            weeklyNextBtn.style.display = (step === weeklySteps.length - 1) ? 'none' : 'inline-block';
            weeklySaveBtn.style.display = (step === weeklySteps.length - 1) ? 'inline-block' : 'none';
        }

        // Next button functionality
        weeklyNextBtn.addEventListener('click', () => {
            if (currentWeeklyStep < weeklySteps.length - 1) {
                currentWeeklyStep++;
                showWeeklyStep(currentWeeklyStep);
            }
        });

        // Previous button functionality
        weeklyPrevBtn.addEventListener('click', () => {
            if (currentWeeklyStep > 0) {
                currentWeeklyStep--;
                showWeeklyStep(currentWeeklyStep);
            }
        });

        // Save responses as JSON
        weeklySaveBtn.addEventListener('click', () => {

            $('#weeklyModal').modal('hide'); // Hide the modal
            $('.modal-backdrop').remove(); // Remove the backdrop manually
            $('body').removeClass('modal-open'); // Remove the 'modal-open' class from the <body>
            $('body').css('padding-right', ''); // Reset body padding, if necessary

            $('#addWeeklyDiv').addClass('d-none');

            //$('#closeWeeklyModal').click();
            const formData = new FormData(weeklyForm);
            const responses = {};
            const dformId = <?php echo $weeklyForm->id ?>;
            formData.forEach((value, key) => {
                // If the key already exists, convert or append to an array
                if (responses.hasOwnProperty(key)) {
                    if (Array.isArray(responses[key])) {
                        responses[key].push(value);
                    } else {
                        responses[key] = [responses[key], value];
                    }
                } else {
                    responses[key] = value;
                }
            });
            console.log(formData);

            // Convert to JSON
            const jsonResponses = JSON.stringify(responses);
            console.log(responses);

            console.log('Save button has the "weekly" class. Proceeding with weekly save logic...');
            fetch('/entries', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ dformId: dformId, responses }),
            })
            .then(response => {
                if (!response.ok) {
                    return Promise.reject('Failed to save');
                }
                return response.json();
            })
            .then(data => {
                console.log('Weekly form saved successfully:', data);
            })
            .catch(error => {
                console.error('Error saving weekly form:', error);
                // Optionally show an error message to the user
            });

            // Optionally close modal after saving
            //$('#weeklyModal').modal('hide');

            $('#successResponses').removeClass('d-none'); // Remove the class
            setTimeout(function() {
                $('#successResponses').addClass('d-none'); // Add the class back after 2 seconds
                //location.reload(); // Reload the page
            }, 3000);
        });

        // Initialize the first step
        showWeeklyStep(currentWeeklyStep);

    </script>

    <script>
        function pagesoon(){
            alert('This page will be available Soon!');
        }
    </script>
    <script type="text/javascript">
        function openLeftMenu(){
            $("#openLeftMenuButton").click();
        }
    </script>
</html>


