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
    </style>
    @endsection
    @section('headertitle')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('messages.Dashboard', [], session()->get('applocale'))}}
        </h2>
    @endsection
    @section('maincontent')
        <!-- 3 cards -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container">
                <div class="pt-2 pb-2 row">
                    <!-- Diaries -->
                    <div class="col-md-4 ">
                    <a href="{{ route('diaries') }}" class="text-decoration-none">
                        <div class="card dashcard text-white shadow-sm rounded-lg b-grey b-bottom-light-blue">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-book fa-2x  c-light-blue"></i> <!-- Reduced icon size -->
                                    
                                    <h5 class="card-title mt-2 c-light-blue">{{ __('messages.Diaries', [], session()->get('applocale'))}}</h5>
                                  
                                </div>
                                <p class="h1 mb-0 c-grey">{{count($diaries)}}</p> <!-- Reduced number size from display-4 to h2 -->
                            </div>
                        </div>
                        </a>
                    </div>
                    <!-- Tasks -->
                    <div class="col-md-4">
                        <a href="{{ route('tasks') }}" class="text-decoration-none">
                            <div class="card dashcard text-white shadow-sm rounded-lg b-grey b-bottom-light-blue">
                                <div class="card-body d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-tasks fa-2x c-light-blue"></i> <!-- Reduced icon size -->
                                        <h5 class="card-title mt-2 c-light-blue">{{ __('messages.Pending tasks', [], session()->get('applocale'))}}</h5>
                                        
                                    </div>
                                    <p class="h1 mb-0 c-grey">{{ count($tasks) }}</p> <!-- Reduced number size from display-4 to h2 -->
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- Time dedicated for thesis -->
                    <div class="col-md-4">
                        <div class="card  text-white shadow-sm rounded-lg b-grey b-bottom-light-blue">
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-hourglass-half c-light-blue fa-2x"></i> <!-- Reduced icon size -->
                                    <h5 class="card-title mt-2 c-light-blue">{{ __('messages.Time Dedicated (hrs)', [], session()->get('applocale'))}}</h5>
                                </div>
                                <p class="h1 mb-0 c-grey">{{ $totalHours ?? 0 }}</p> <!-- Reduced number size from display-4 to h2 -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Milestone -->
        <div class="max-w-7xl mx-auto sm:px-6 mt-2 lg:px-8">
            <div class="container">
                <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                  
                    <div class="row">
                        <!-- Left Part: Content (col-md-10) -->
                        <div class="@if($lastMilestone) col-md-8 @else col-md-10 @endif">
                            <p class="c-grey h5">{{ __('messages.Next milestone', [], session()->get('applocale'))}}</p>
                            <p class="c-light-blue h3 pt-2  mt-4">{{ $lastMilestone->milestone  ?? 'Add a new milestone to show it here'}}</p>
                        </div>
                        @if($lastMilestone) 
                        <div class="col-md-2 d-flex justify-content-end align-items-start">
                            <!-- Trigger the modal with a button -->
                           <button class="btn btn-block bg-green" onclick="finishMilestone({{ $lastMilestone->id }})"><i class="fa fa-flag-checkered mr-4"> </i>{{ __('messages.Finish', [], session()->get('applocale'))}}</button>
                        </div>
                        @endif
                        <!-- Right Part: Button (col-md-2) -->
                        <div class="col-md-2 d-flex justify-content-end align-items-start">
                            <!-- Trigger the modal with a button -->
                            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#milestoneModal">{{ __('messages.Add new', [], session()->get('applocale'))}} +</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Insights -->
        <div class="max-w-7xl mx-auto sm:px-6 mt-4 lg:px-8">
            <div class="container">
                <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                    <p class="c-grey h5 mb-4">{{ __('messages.Insights', [], session()->get('applocale'))}}</p>
                    <div class="row">
                        <div class="container mb-4">
                            <!--<p>{{ __('messages.InsightsMessage', [], session()->get('applocale'))}}</p>-->
                            <h1 class="mb-4">{{ __('messages.InsightsMessage2', [], session()->get('applocale'))}}</h1>
                            <a class="mr-4 btn btn-info" target="_blank" href="https://luispprieto-uva.shinyapps.io/UVA_Feb2025_long-dash-xl/?u={{Auth::user()->username}}">{{ __('messages.Insights', [], session()->get('applocale'))}}</a>
                        </div>
                        <div  class="row w-full mt-4 mb-2">
                            <div class="col-6">
                                <h4 class="h5 ml-4">Progress over time</h4>
                                <div  class="container">
                                    <canvas id="progressChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="h5 ml-4">Progress predictors</h4>
                                <div class="container">
                                    <canvas id="progressPredChart" width="400" height="200"></canvas>
                                </div>
                            </div>
                             <div class="col-6 mt-4">
                                <h4 class="h5 ml-4">Progress predictors</h4>
                                <div class="container">
                                     <canvas id="forestPlotChart" width="400" height="200"></canvas>
                                </div>
                            </div>

                           
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Summary -->
        <!--<div class="max-w-7xl mx-auto sm:px-6 mt-4 lg:px-8">
            <div class="container">
                <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                    <p class="c-grey h5 mb-4">{{ __('messages.Achievement Summary', [], session()->get('applocale'))}}</p>
                    <div class="row">
                        -- Left Part: Content (col-md-10) --
                            -- Insight 1: Total Time Dedicated --
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-hourglass-end fa-2x text-info"></i>
                                    <div class="ml-3">
                                        <h5 class="mb-0">{{ __('messages.Total Time Dedicated', [], session()->get('applocale'))}}</h5>
                                        <p class="text-muted">{{ $totalHours}} {{ __('messages.hours so far', [], session()->get('applocale'))}}</p>
                                    </div>
                                </div>
                            </div>

                            -- Insight 2: Tasks Completed --
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle fa-2x text-success"></i>
                                    <div class="ml-3">
                                        <h5 class="mb-0">{{ __('messages.Tasks Completed', [], session()->get('applocale'))}}</h5>
                                        <p class="text-muted">{{ count($completedTasks) }} {{ __('messages.out of', [], session()->get('applocale'))}} {{ count($completedTasks)+count($tasks) }} {{ __('messages.tasks', [], session()->get('applocale'))}}</p>
                                    </div>
                                </div>
                            </div>

                            -- Insight 3: Papers Submitted --
                            <div class="col-md-4">
                                <div class="d-flex align-items-center">
                              
                                    <i class="fas fa-flag-checkered fa-2x text-warning"></i>
                                    <div class="ml-3">
                                        <h5 class="mb-0">{{ __('messages.Achieved milestones', [], session()->get('applocale'))}}</h5>
                                        <p class="text-muted"> {{ $countMilestones }} @if($countMilestones == 1) {{ __('messages.milestone', [], session()->get('applocale'))}} @else {{ __('messages.milestones', [], session()->get('applocale'))}} @endif </p>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>-->

        <!-- Progress and new papers 
        <div class="max-w-7xl mx-auto sm:px-6 mt-4 lg:px-8">
            <div class="container">
                <div class="row">
                    <-- First Div (col-md-6) --
                    <div class="col-md-6">
                        <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                            <p class="c-grey h5 mb-4">Progress</p>
                            <div class="row">
                                <!-- Placeholder for Progress Bar --
                                <div class="col-md-12">
                                    <p>Overall Progress</p>
                                    <div class="progress mt-4">
                                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">
                                            65%
                                        </div>
                                    </div>
                                </div>

                                <!-- Placeholder for additional progress insights --
                                <div class="col-md-12 mt-4">
                                    <ul>
                                        <li class="mt-2">Chapters Completed: 3 out of 5</li>
                                        <li class="mt-2">Research Papers Published: 2 out of 3</li>
                                        <li class="mt-2">Supervisor Meetings: 5 out of 8</li>
                                        <li class="mt-2">Upcoming Deadline: Submission of next chapter in 2 weeks</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Second Div (col-md-6) --
                    <div class="col-md-6">
                        <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                            <p class="c-grey h5 mb-4">New Papers</p>
                            <div class="row">
                                <!-- Paper 1 --
                                <div class="col-md-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Innovations in Educational Technologies</h5>
                                            <p class="card-text">A deep dive into how educational technologies are revolutionizing learning methods across institutions.</p>
                                            <a href="https://doi.org/10.1016/j.edurev.2020.100375" target="_blank" class="mt-2 btn btn-primary">Read More</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Paper 2 --
                                <div class="col-md-12 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">The Role of AI in Personalized Education</h5>
                                            <p class="card-text">Exploring the potential of AI in tailoring education to individual student needs.</p>
                                            <a href="https://journals.sagepub.com/doi/10.1177/0011000015592107" target="_blank" class="mt-2 btn btn-primary">Read More</a>
                                        </div>
                                    </div>
                                </div>

                            
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>-->

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
                location.reload(); // Reload the page to reflect changes
            })
            .catch(error => {
                console.error("Error:", error);
                alert("An error occurred while updating the milestone.");
            });
        }
       </script>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>




    <script>
        var ctx = document.getElementById('progressChart').getContext('2d');
        
        var progressData = @json($progress);

        var labels = progressData.map(function(item) {
            return item.time;
        });

        var data = progressData.map(function(item) {
            return item.data;
        });

        // Function to calculate the linear regression (trend line)
        function getTrendLine(data) {
            var N = data.length;
            var sumX = 0;
            var sumY = 0;
            var sumXY = 0;
            var sumX2 = 0;

            // Sum all necessary values
            for (var i = 0; i < N; i++) {
                sumX += i; // Use index as x
                sumY += data[i]; // The actual data is y
                sumXY += i * data[i];
                sumX2 += i * i;
            }

            // Calculate slope (m) and intercept (b)
            var m = (N * sumXY - sumX * sumY) / (N * sumX2 - sumX * sumX);
            var b = (sumY - m * sumX) / N;

            // Calculate trend line data
            var trendLine = [];
            for (var i = 0; i < N; i++) {
                trendLine.push(m * i + b); // y = mx + b
            }

            return trendLine;
        }

        // Calculate the trend line
        var trendLine = getTrendLine(data);

        // Create the chart
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Progress',
                    data: data,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    fill: false
                }, {
                    label: 'Trend Line',
                    data: trendLine, // Add trend line data
                    borderColor: 'rgba(255, 159, 64, 1)',
                    borderDash: [5, 5], // Dashed line for the trend line
                    fill: false,
                    pointRadius: 0 // Remove points from the trend line
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: false,
                        min: 1,
                        max: 7
                    }
                }
            }
        });

        /////////////////////////  CHART 2  //////////////////////

        const ctx2 = document.getElementById("progressPredChart").getContext("2d");

// Data passed from Laravel controller
const chartData = @json($chartData);

// Extract the labels and calculate base (min) and range (max - min)
const labels2 = Object.keys(chartData);
const baseData = labels2.map(label => chartData[label]?.min || 0);
const rangeData = labels2.map(label => (chartData[label]?.max || 0) - (chartData[label]?.min || 0));

// Build data points for the average scatter dataset
const avgPoints = labels2.map(label => {
    return { x: chartData[label]?.avg || 0, y: label }; // Swap x and y for horizontal representation
});



var chart2 = new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: labels2,
        datasets: [
            // Line dataset for Base instead of an invisible bar
            
            // Dataset for the range (visible bar from min to max)
            {
                label: 'Range (Min to Max)',
                data: rangeData,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                stack: 'range'
            },
            // Scatter dataset for the average point
            {
                type: 'scatter',
                label: 'Average',
                data: avgPoints,
                backgroundColor: 'red',
                borderColor: 'red',
                pointRadius: 5,
                showLine: false, // Prevents connecting points
                yAxisID: 'y'
            }
        ]
    },
    options: {
        indexAxis: 'y', // Convert to horizontal chart
        plugins: {
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        responsive: true,
        scales: {
            x: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Value'
                }
            },
            y: {
                stacked: false // Ensure scatter and line are not stacked
            }
        }
    }
});

    </script>


    @endsection
</x-app-layout>
