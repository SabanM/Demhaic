<x-app-layout>
    @section('style')
    <style>
        .dashcard {
            transition: transform 2s ease; /* Smooth transition for scaling */
        }
        .dashcard:hover{
           scale:1.05;
           transition: transform 0.3s ease; 
           cursor:pointer;
        }

        .chart-container { 
          width: 80%; 
          margin: auto; 
          padding: 20px; 
        }
        #decisionTree {
          width: 80%;
          height: 500px;
          margin: auto;
          padding-left:1%;
          border: 1px solid #ccc;
        }
        /* Spinner styling */
          .spinner {
            margin: 20px auto; /* Centers the spinner */
            border: 8px solid #f3f3f3; /* Light grey border */
            border-top: 8px solid #3498db; /* Blue border on top */
            border-radius: 50%; /* Rounded shape */
            width: 60px;
            height: 60px;
            animation: spin 1s linear infinite; /* Animation settings */
          }

          /* Keyframes for the spin animation */
          @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
          }


          @media (max-width: 576px) {
            
            .dashcard {
                  height:100%;
            }
            .dashcard .card-body {
                flex-direction: column;
                align-items: center;
            
            }
            .dashcard .card-body > div,
            .dashcard .card-body > p {
                width: 100%;
                text-align: center;


            }
            .dashcard .card-body > p {
                margin-top: 10px; /* Adds some space between the text and the number */
                font-size: 18pt;
            }
        }

      </style>

    @endsection
    @section('headertitle')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('messages.Dashboard', [], session()->get('applocale'))}}
        </h2>
    @endsection
    @section('maincontent')
    <!-- 3 cards -->
    <div class="max-w-7xl mx-auto sm:px-8 mt-2 lg:px-10">
        <div class="container">
            <div class="pt-2 pb-2 row">
                <!-- Diaries -->
                <div class="col-md-4 col-12 card-dashboard">
                    <a href="{{ route('diaries') }}" class="text-decoration-none">
                        <div class="card mt-2 dashcard text-white shadow-sm rounded-lg b-grey b-bottom-light-blue">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-book fa-2x c-light-blue"></i>
                                    <h5 class="card-title mt-2 c-light-blue">
                                        {{ __('messages.Diaries', [], session()->get('applocale'))}}
                                    </h5>
                                </div>
                                <p class="h1 mb-0 c-grey">{{ count($diaries) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Tasks -->
                <div class="col-md-4 col-12 card-dashboard">
                    <a href="{{ route('tasks') }}" class="text-decoration-none">
                        <div class="card mt-2 dashcard text-white shadow-sm rounded-lg b-grey b-bottom-light-blue">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-tasks fa-2x c-light-blue"></i>
                                    <h5 class="card-title mt-2 c-light-blue">
                                        {{ __('messages.Pending tasks', [], session()->get('applocale'))}}
                                    </h5>
                                </div>
                                <p class="h1 mb-0 c-grey">{{ count($tasks) }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                <!-- Time dedicated for thesis -->
                <div class="col-md-4 col-12 card-dashboard">
                    <div class="card mt-2 dashcard text-white shadow-sm rounded-lg b-grey b-bottom-light-blue">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-hourglass-half fa-2x c-light-blue"></i>
                                <h5 class="card-title mt-2 c-light-blue">
                                    {{ __('messages.Time Dedicated (hrs)', [], session()->get('applocale'))}}
                                </h5>
                            </div>
                            <p class="h1 mb-0 c-grey">{{ $totalHours ?? 0 }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Milestone -->
        <div class="max-w-7xl mx-auto sm:px-8 mt-2 lg:px-10">
            <div class="container">
                <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                  
                    <div class="row">
                        <!-- Left Part: Content (col-md-10) -->
                        <div class="@if($lastMilestone) col-md-8 @else col-md-10 @endif">
                            <p class="c-grey h4">{{ __('messages.Next milestone', [], session()->get('applocale'))}}</p>
                            <p class="c-light-blue h3 pt-2  mt-4">{{ $lastMilestone->milestone  ?? 'Add a new milestone to show it here'}}</p>
                        </div>
                        @if($lastMilestone) 
                        <div class="col-md-2 d-flex mt-4 justify-content-end align-items-start">
                            <!-- Trigger the modal with a button -->
                           <button class="btn btn-block  bg-green" onclick="finishMilestone({{ $lastMilestone->id }})"><i class="fa fa-flag-checkered mr-4"> </i>{{ __('messages.Finish', [], session()->get('applocale'))}}</button>
                        </div>
                        @endif
                        <!-- Right Part: Button (col-md-2) -->
                        <div class="col-md-2 d-flex mt-4 justify-content-end align-items-start">
                            <!-- Trigger the modal with a button -->
                            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#milestoneModal">{{ __('messages.Add new', [], session()->get('applocale'))}} +</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Insights -->
        <div class="max-w-7xl mx-auto sm:px-8 mt-4 lg:px-10">
                    <div class="container">
                
                        @php
                            $locale = session()->get('applocale');
                            if($insights){
                            $insightText = ($locale === 'es' && $insights->insight_es)
                                ? $insights->insight_es
                                : $insights->insight;
                            }
                        @endphp
                        <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                            <h1 class="c-grey h4">{{ __('messages.Insights', [], session()->get('applocale'))}}<sup style="color:red; margin-left:5px">*</sup></h1>
                            <div class="row">
                                <div class="container mb-4 text-left">
                                    @if(count($diaries) <= 10)
                                        <p>{{ __('messages.InsightsMessage', [], session()->get('applocale')) }}</p>
                                    @else
                                        <h1 id="loading-text" style="line-height: 30px;">
                                        {{ __('messages.Analysing your diaries...', [], session()->get('applocale'))}}    
                                        </h1>

                                        <div id="spinner" class="spinner mx-auto my-3"></div>

                                        @if($insights)
                                        <div class="container">
                                            <h1 id="insights-text" class="d-none" style="line-height: 30px; text-align: justify;">
                                                {!! str_replace(['• ', '* '], '<p class="mt-4">• ', $insightText ?? '') !!}
                                            </h1>

                                            <h1 id="insights-text" class="d-none" style="line-height: 30px; text-align: justify;">
                                                {!! str_replace(['• ', '* '], '<p class="mt-4">• ', $insights->insight_es ?? 'no') !!}
                                            </h1>
                                            <!--<p>{{ __('messages.InsightsMessage', [], session()->get('applocale'))}}</p>-->
                                            <p class="mb-4 h6 mt-4 text-info">{{ __('messages.InsightsMessage2', [], session()->get('applocale'))}}</p>
                                            <a class="mr-4 btn btn-info" target="_blank" href="{{ route('progress')}}"><p class="ml-4 mr-4">{{ __('messages.Progress', [], session()->get('applocale'))}}</p></a>
                                        </div>   
                                        @else
                                            <h1 id="insights-text" class="d-none" style="line-height: 30px; text-align: justify;">

                                                {{ __('messages.InsightsMessage3', [], session()->get('applocale'))}}
                                            </h1>
                                        @endif
                                    @endif
                                </div>
                                <p style="border-top: #2257AC solid 1px; font-style:italic; padding-top:5px; font-size:8pt"><span style="color:red; margin-left:5px; margin-right:10px">*</span>{{ __('messages.Disclaimer', [], session()->get('applocale'))}}</p>
                                                    
                            </div>
                        </div>
                    </div>
                </div>


       <!-- Modal Milestone Structure -->
        <div class="modal fade mt-4" id="milestoneModal" tabindex="-1" role="dialog" aria-labelledby="milestoneModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title h4" id="milestoneModalLabel">{{ __('messages.Add New Milestone', [], session()->get('applocale'))}}</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form to save the milestone -->
                        <form id="milestone-form" method="POST" action="{{ route('milestones.store') }}">
                            @csrf <!-- CSRF token for security -->
                            
                            <!-- Milestone description -->
                            <div class="form-group">
                                <label for="milestone-input">{{ __('messages.New Milestone', [], session()->get('applocale'))}}</label>
                                <textarea type="text" rows="5" class="form-control" id="milestone-input" name="milestone" placeholder="{{ __('messages.Enter your milestone', [], session()->get('applocale') )}}" required></textarea>
                            </div>

                            <!-- Hidden input for user ID if needed (assuming user is logged in) -->
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                           

                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.Cancel', [], session()->get('applocale'))}}</button>
                        <button type="submit" class="btn btn-success" id="save-milestone-btn" onclick="document.getElementById('milestone-form').submit();">{{ __('messages.Save Milestone', [], session()->get('applocale'))}}</button>
                    </div>
                </div>
            </div>
        </div>



    @endsection

    @section('scripts')
        <script>
            function finishMilestone(milestoneId) {
                // Confirm the action
                if (!confirm("Are you sure you want to mark this milestone as finished?")) {
                    return;
                }
                // Send an AJAX request
                fetch(`/milestones/finish/${milestoneId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    },
                    body: JSON.stringify({ finished_at: new Date() }),
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error("Failed to update the milestone.");
                })
                .then(data => {
                    alert(data.message || "Milestone updated successfully!");
                    window.location.href = "/dashboard"; // Reload the page to reflect changes
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("An error occurred while updating the milestone.");
                });
            }
        </script>

        <!-- Load Chart.js -->

        <!-- Optionally include Moment.js for time scale support if not already bundled -->
        <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>

        <script src="https://d3js.org/d3.v7.min.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const spinner = document.getElementById('spinner');
                const loadingText = document.getElementById('loading-text');
                const insightsText = document.getElementById('insights-text');

                if (spinner && loadingText && insightsText) {
                    setTimeout(() => {
                        spinner.classList.add('d-none');
                        loadingText.classList.add('d-none');
                        insightsText.classList.remove('d-none');
                    }, 1000);
                }
            });
        </script>

       



    @endsection
</x-app-layout>
