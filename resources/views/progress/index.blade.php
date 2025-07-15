<x-app-layout>
    @section('headertitle')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

              {{ __('messages.Progress', [], session()->get('applocale'))}}                       
        </h2>
        <style type="text/css">
        	#decisionTree {
	          width: 100%;
	          height: 500px;
	          margin: auto;
	          padding-left:1%;
	          border: 1px solid #ccc;
	        }

	        .chart-title {
	        	color:#2980b9;
	        };
        </style>
    @endsection

    @section('maincontent')
      
	<!-- New tasks -->
	<div class="max-w-7xl mx-auto sm:px-8 mt-2 lg:px-10">
	    <div class="container">
	        <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
	              <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li class="nav-item">
      <a
        class="nav-link active h5"
        id="my-progress-tab"
        data-toggle="tab"
        href="#my-progress"
        role="tab"
        aria-controls="my-progress"
        aria-selected="true"
      >
        {{ __('messages.My progress', [], session()->get('applocale')) }}
      </a>
    </li>
    <li class="nav-item">
      <a
        class="nav-link h5"
        id="journaling-tab"
        data-toggle="tab"
        href="#journaling"
        role="tab"
        aria-controls="journaling"
        aria-selected="false"
      >
        {{ __('messages.Journaling', [], session()->get('applocale')) }}
      </a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content p-4">
    <div
      class="tab-pane fade show active"
      id="my-progress"
      role="tabpanel"
      aria-labelledby="my-progress-tab"
    >
      <!-- Content for My Progress -->
      <div class="max-w-10xl mx-auto sm:px-6 lg:px-10">


                @php
                    $locale = session()->get('applocale');
                    if($insights){
                        $daily_progressText = ($locale === 'es' && $insights->daily_progress)
                            ? $insights->daily_progress_es
                            : $insights->daily_progress;

                        $weekly_progressText = ($locale === 'es' && $insights->weekly_progress)
                            ? $insights->weekly_progress_es
                            : $insights->weekly_progress;

                        $factor_predictorsText = ($locale === 'es' && $insights->factor_predictors)
                            ? $insights->factor_predictors_es
                            : $insights->factor_predictors;

                        $regression_treeText = ($locale === 'es' && $insights->regression_tree)
                            ? $insights->regression_tree_es
                            : $insights->regression_tree;
                    }
                @endphp

                        <div class="container">
                            <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                                <!--p class="c-grey h5 mb-4">{{ __('messages.Insights', [], session()->get('applocale'))}}</p>-->
                                <div class="row">
                                    
                                    @if(count($diaries) >= 10)
                                    <div class="row w-full mt-4 ">
                                        <h4 class="h5 ml-4 chart-title">
                                        {{ __('messages.My daily progress over time', [], session()->get('applocale'))}}        
                                        </h4>
                                    </div>
                                    <div  class="row w-full mb-2">

                                        <div class="col-12">
                                           
                                            <div class="ml-4 mb-4" style="text-align: justify;">{!! str_replace(['• ', '* '], '<p class="mt-4">• ', $daily_progressText ?? '') !!}<sup style="color:red; margin-left:5px">*</sup></p></div>
                                        
                                            <div  class="mt-4 container">
                                                <canvas id="progressOverTimeChart" width="400" height="120"></canvas>
                                            </div>
                                        </div>
                                       
                                    </div>
                                    <div class="row w-full mt-4 mb-2">
                                        <h4 class="h5 ml-4 mb-4 chart-title">
                                        {{ __('messages.Progress by weeks', [], session()->get('applocale'))}}         
                                        </h4>
                                    </div>
                                    <div class="row w-full mb-2">
                                        <div class="col-md-6">
                                            <div class="container mt-4">
                                                 <canvas id="progressByWeekChart" width="400" height="250"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="ml-4 mb-4" style="text-align: justify;">{!! str_replace(['• ', '* '], '<p class="mt-4">• ', $weekly_progressText ?? '') !!}<sup style="color:red; margin-left:5px">*</sup></p></div>

                                        </div>
                                    </div>
                                    <div class="row w-full mt-4 mb-2">
                                        <h4 class="h5 ml-4 mb-4 chart-title">
                                        {{ __('messages.Predictors of progress', [], session()->get('applocale'))}}             
                                        </h4>
                                    </div>

                                    <div class="row w-full">

                                        <div class="col-md-6">
                                            <div class="ml-4 mb-4" style="text-align: justify;">{!! str_replace(['• ', '* '], '<p class="mt-4">• ', $factor_predictorsText ?? '') !!}<sup style="color:red; margin-left:5px">*</sup></p></div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="container mt-4">
                                                <canvas id="forestPlotChart" width="400" height="250"></canvas>
                                            </div>
                                        </div>
                                    </div>

                                  
                                    <div class="row w-full mt-4 mb-2">
                                          <h4 class="h5 ml-4 chart-title">
                                          {{ __('messages.A tree of your better/worse days', [], session()->get('applocale'))}}        
                                          </h4>
                                    </div>
                                     <div  class="row w-full mb-2">
                                          <div class="container">
                                            <div class="col-12">
                                              
                                            <div class="ml-4 mb-4" style="text-align: justify;">{!! str_replace(['• ', '* '], '<p class="mt-4">• ', $regression_treeText ?? '') !!}<sup style="color:red; margin-left:5px">*</sup></p></div>
                                                <div id="decisionTree"></div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
           
                            </div>
         
                        </div>
           
                    </div>
                    <p style="border-top: #2257AC solid 1px; font-style:italic; padding-top:5px; font-size:10pt"><span style="color:red; margin-left:5px; margin-right:10px">*</span>{{ __('messages.Disclaimer', [], session()->get('applocale'))}}</p>
                              
    </div>
    <div
      class="tab-pane fade"
      id="journaling"
      role="tabpanel"
      aria-labelledby="journaling-tab"
    >
      <!-- Content for Journaling -->


      <div class="table-responsive">

      <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('messages.Date', [], session()->get('applocale'))}}</th>
                        <th>{{ __('messages.Progress', [], session()->get('applocale'))}}</th>
                        <th>{{ __('messages.Journal', [], session()->get('applocale'))}}</th>
                        <th>{{ __('messages.Goals', [], session()->get('applocale'))}}</th>
                        
                    </tr>
                </thead>
                <tbody>
                @foreach ($diaries as $index => $entry)
                    @php
                        //use Illuminate\Support\Str;
                        $entryDateDetail = null;
                        $details = json_decode($entry->entry, true);
                        foreach ($details as $key => $value) {
                            if ($key === 'Entry Date') {
                                $entryDateDetail = $value;
                                break;
                            }
                        }
                    @endphp

                        <tr>
                            @foreach ($details as $question => $answer)
                                @if ($question == 'Entry Date')
                                <td class="text-nowrap">{{ $answer ?? '' }}</td>
                                @endif
                                @if(Str::contains($question, 'satisf'))
                                <td>{{ $answer ?? '' }}</td>
                                @endif
                                @if (Str::contains($question, ['happened', 'pasado']))
                                <td>{{ $answer ?? '' }}</td>
                                @endif
                                @if (Str::contains($question, ['tomorrow', 'next', 'siguiente']))
                                <td>{!! $answer ?? '' !!}</td>
                                @endif
                               
                            @endforeach

                           
                        </tr>
                        @endforeach
                </tbody>
            </table>
        </div>

      </div>
    </div>
  </div>
</div>

       
    @endsection

    @section('scripts')
 		<!-- Load Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Optionally include Moment.js for time scale support if not already bundled -->
        <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0"></script>
        <script src="https://cdn.jsdelivr.net/npm/@sgratzl/chartjs-chart-boxplot"></script>
        <!-- Add this to your HTML if not already there -->
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation@1.4.0/dist/chartjs-plugin-annotation.min.js"></script>

        <script src="https://d3js.org/d3.v7.min.js"></script>
        <script>
            // Ensure that Laravel outputs a valid JSON object
            var chartsData = {!! $chartsDataJson ?? null !!};
            console.log(chartsData);

            // --- Chart 1: Progress Over Time (Line Chart) ---
            var ctx1 = document.getElementById('progressOverTimeChart').getContext('2d');
          

            if (chartsData.daily_progress) {
                var dates = chartsData.daily_progress.dates;
                var progressValues = chartsData.daily_progress.progress;


                // Function to calculate the linear regression (trend line)
                function getTrendLine(progressValues) {
                    var N = progressValues.length;
                    var sumX = 0;
                    var sumY = 0;
                    var sumXY = 0;
                    var sumX2 = 0;

                    for (var i = 0; i < N; i++) {
                        sumX += i;
                        sumY += progressValues[i];
                        sumXY += i * progressValues[i];
                        sumX2 += i * i;
                    }

                    var m = (N * sumXY - sumX * sumY) / (N * sumX2 - sumX * sumX);
                    var b = (sumY - m * sumX) / N;

                    var trendLine = [];

        

                    for (var i = 0; i < N; i++) {
                        trendLine.push(m * i + b);
                    }

                    return trendLine;
                }

                function getTrendEndpoints(progressValues) {
                    var N = progressValues.length;
                    var sumX = 0;
                    var sumY = 0;
                    var sumXY = 0;
                    var sumX2 = 0;

                    for (var i = 0; i < N; i++) {
                        sumX += i;
                        sumY += progressValues[i];
                        sumXY += i * progressValues[i];
                        sumX2 += i * i;
                    }

                    var m = (N * sumXY - sumX * sumY) / (N * sumX2 - sumX * sumX);
                    var b = (sumY - m * sumX) / N;

                    var first = b;               // y at x = 0
                    var last = m * (N - 1) + b;  // y at x = N - 1

                    return [first, last];
                }

                // 👇 This was missing
                var trendLine = getTrendEndpoints(progressValues);

                console.log("Progress Over Time Dates:", dates);
                console.log("Progress Over Time Values:", progressValues);
                console.log("Trend Line Values:", trendLine);

                var progressOverTimeChart = new Chart(ctx1, {
                    type: 'line',
                    data: {
                        labels: dates,
                        datasets: [{
                            label: 'Progress',
                            data: progressValues,
                            Color: 'blue',
                            fill: false,
                            tension: 0.1
                        }, 
                        {
                            label: 'Trend Line',
                            data: [
                                { x: dates[0], y: trendLine[0] },
                                { x: dates[dates.length - 1], y: trendLine[1] }
                            ],
                            Color: 'rgba(255, 159, 64, 1)',
                            borderDash: [5, 5],
                            fill: false,
                            pointRadius: 0,
                            tension: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    parser: 'YYYY-MM-DD',
                                    unit: 'day',
                                    displayFormats: {
                                        day: 'YYYY-MM-DD'
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Overall satisfaction with progress'
                                },
                                beginAtZero: false,
                                suggestedMin: 1,
                                suggestedMax: 7
                            }
                        }
                    }
                });
            }
            else {
                console.error("chartsData.daily_progress is undefined");
            }

            // --- Chart 2: Progress by weeks ---

                // Ensure Chart.js BoxPlot plugin is loaded
                //Chart.register(ChartBoxPlotChart);

            // Get the chart canvas
            var ctx2 = document.getElementById('progressByWeekChart').getContext('2d');

            // Prepare data
            var weekLabels = [];
            var weekData = [];
            var scatterData = [];
            var annotations = {};

            if (chartsData.weekly_progress.progress_by_week) {
                var progressByWeek = chartsData.weekly_progress.progress_by_week;
                var sampleSizes = chartsData.weekly_progress.sample_sizes;

                Object.keys(progressByWeek).forEach((week, index) => {
                    weekLabels.push("Week " + week);
                    let values = progressByWeek[week];

                    // BoxPlot data (full array)
                    weekData.push(values);

                    // Scatter plot data (individual points)
                    values.forEach(value => {
                        scatterData.push({ x: index + 1, y: value }); // Align points correctly
                    });

                    // Annotation for sample size (N = X)
                    if (sampleSizes[week]) {
                        annotations[`nLabel${index}`] = {
                            type: 'label',
                            xValue: index + 1,
                            yValue: 0.5, // Position below the x-axis
                            content: `N=${sampleSizes[week]}`,
                            color: 'black',
                            font: {
                                size: 12,
                                weight: 'bold'
                            }
                        };
                    }
                });

                // Create the box plot with overlaid scatter plot and annotations
                var progressByWeekChart = new Chart(ctx2, {
                    type: 'boxplot',
                    data: {
                        labels: weekLabels,
                        datasets: [
                            {
                                label: 'Overall Satisfaction with Progress',
                                data: weekData,
                                borderColor: 'black',
                                borderWidth: 1,
                                backgroundColor: 'rgba(0, 123, 255, 0.5)',
                                outlierColor: 'blue',
                                itemRadius: 3
                            },
                            
                        ]
                    },
                    options: {
                        plugins: {
                            legend: { display: false },
                            annotation: {
                                annotations: annotations
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: { display: true, text: 'Overall Satisfaction with Progress' }
                            },
                            x: {
                                title: { display: true, text: 'Week' },
                                ticks: {
                                    callback: (val, index) => weekLabels[index] // Ensure proper alignment
                                }
                            }
                        }
                    }
                });

            } else {
                console.error("chartsData.weekly_progress is undefined");
            }

            // --- Chart 3: Forest Plot (Horizontal Bar Chart) ---
            // Note: For a true forest plot with error bars you might need a plugin.
            // Here we use a simple horizontal bar chart to display coefficients.
            var ctx3 = document.getElementById('forestPlotChart').getContext('2d');
            // Extract data from JSON
            var predictors = chartsData.factor_predictors.predictors;
            var coefficients = chartsData.factor_predictors.coefficients;
            var lowerErrors = chartsData.factor_predictors.lower_errors;
            var upperErrors = chartsData.factor_predictors.upper_errors;

            // Reverse predictors to match Chart.js category scale order
            var reversedPredictors = [...predictors].reverse();

            // Prepare scatter plot data, shifting Y by +1 for padding alignment
            var scatterData2 = predictors.map((predictor, index) => ({
                x: coefficients[index],
                y: index// shift by 1 to align with padded labels
            }));



            // Custom plugin to draw horizontal error bars
            const errorBarsPlugin = {
                id: 'errorBars',
                beforeDraw(chart) {
                    const ctx = chart.ctx;
                    const xScale = chart.scales.x;
                    const yScale = chart.scales.y;

                    ctx.save();
                    ctx.strokeStyle = 'cornflowerblue';
                    ctx.lineWidth = 2;

                    scatterData2.forEach((point, index) => {
                        let y = yScale.getPixelForValue(point.y ); // Use shifted y
                        let xMin = xScale.getPixelForValue(point.x - lowerErrors[index]); // Lower bound
                        let xMax = xScale.getPixelForValue(point.x + upperErrors[index]); // Upper bound

                        // Draw the horizontal error bar
                        ctx.beginPath();
                        ctx.moveTo(xMin, y);
                        ctx.lineTo(xMax, y);
                        ctx.stroke();

                        // Draw small caps at both ends of the error bar
                        ctx.beginPath();
                        ctx.moveTo(xMin, y - 3);
                        ctx.lineTo(xMin, y + 3);
                        ctx.moveTo(xMax, y - 3);
                        ctx.lineTo(xMax, y + 3);
                        ctx.stroke();
                    });

                    ctx.restore();
                }
            };


            // Create the Forest Plot
            var forestPlotChart = new Chart(ctx3, {
                type: 'scatter',
                data: {
                    datasets: [{
                        label: 'Predictors of Progress',
                        data: scatterData2,
                        backgroundColor: 'cornflowerblue',
                        pointRadius: 6,
                        pointHoverRadius: 7,
                        showLine: false
                    }]
                },
                options: {
                    plugins: {
                        legend: { display: false },
                        annotation: {
                            annotations: {
                                verticalLine: {
                                    type: 'line',
                                    xMin: 0,
                                    xMax: 0,
                                    //yMin: 0.5,
                                    //yMax: predictors.length + 0.5,
                                    borderColor: 'rgba(244, 143, 160, 1)',
                                    borderWidth: 4,
                                    borderDash: []
                                }
                            }
                        }
                    },
                    scales: {
                        x: {

                            title: { display: true, text: 'Effect on Progress Score' },
                            min: Math.min(...coefficients) - 2,
                            max: Math.max(...coefficients) + 2,
                        },
                        y: {
                            type: 'category',
                            labels: [...reversedPredictors, ''], // Add padding top and bottom
                            title: { display: true },
                        }
                    }
                },
                plugins: [errorBarsPlugin] // Attach the error bars plugin
            });




            // --- Chart 4: Decision Tree (D3.js Tree Diagram) ---
            // The decision_tree object from your JSON is assumed to be hierarchical.

            var treeData = chartsData.regression_tree;

            // Set up dimensions for the tree diagram
            var margin = { top: 20, right: 150, bottom: 30, left: 150 },
                width = document.getElementById('decisionTree').clientWidth - margin.left - margin.right,
                height = 500 - margin.top - margin.bottom;

            // Append the svg object to the div called 'decisionTree'
            var svg = d3.select("#decisionTree").append("svg")
              .attr("width", width + margin.left + margin.right)
              .attr("height", height + margin.top + margin.bottom)
              .append("g")
              .attr("transform", "translate(" + margin.left + "," + margin.top + ")");

            // Create a tree layout with specified size
            var treemap = d3.tree().size([height, width]);

            // Convert treeData to a hierarchy
            var root = d3.hierarchy(treeData, function (d) {
                var children = [];
                if (d.left) { children.push(d.left); }
                if (d.right) { children.push(d.right); }
                return children.length ? children : null;
            });

            // Generate the tree layout
            root = treemap(root);

            // Create links between nodes
            var link = svg.selectAll(".link")
              .data(root.links())
              .enter().append("path")
              .attr("class", "link")
              .attr("fill", "none")
              .attr("stroke", "#ccc")
              .attr("d", d3.linkHorizontal()
                  .x(d => d.y)
                  .y(d => d.x));

            // Create "yes" and "no" labels on decision paths
            svg.selectAll(".link-label")
              .data(root.links())
              .enter()
              .append("text")
              .attr("class", "link-label")
              .attr("x", d => (d.source.y + d.target.y) / 2)
              .attr("y", d => (d.source.x + d.target.x) / 2)
              .style("text-anchor", "middle")
              .style("font-size", "12px")
              .style("font-style", "italic")
              .text((d, i) => (d.source.children && d.target === d.source.children[0]) ? "yes" : "no"); // Left child is "yes", right is "no"

            // Create nodes as groups
            var node = svg.selectAll(".node")
              .data(root.descendants())
              .enter().append("g")
              .attr("class", "node")
              .attr("transform", d => `translate(${d.y},${d.x})`);

            // Append circles for nodes
            node.append("circle")
              .attr("r", 10)
              .attr("fill", "#fff")
              .attr("stroke", "steelblue")
              .attr("stroke-width", 3);

            // Append text labels for nodes (display full condition or value)
            node.append("text")
			  .attr("dy", ".35em")
			  .attr("x", d => d.children ? -15 : 15)
			  .style("text-anchor", d => d.children ? "end" : "start")
			  .style("font-weight", d => d.children ? "bold" : "normal")
			  .text(d => {
			      if (d.data.feature) {
			          return `${d.data.feature} <= ${d.data.threshold || ''}`;
			      } else {
			          return `Progress=${parseFloat(d.data.value).toFixed(2)}\n${d.data.n || ''}`;
			      }
			  })
			  .call(wrapText, 100);


            // Function to wrap text within a width limit
            function wrapText(text, width) {
			  text.each(function() {
			    var textEl = d3.select(this),
			        textContent = textEl.text();
			    
			    // Split text at newline characters
			    var lines = textContent.split("\n");
			    
			    // Clear the original text
			    textEl.text("");
			    
			    // Append a tspan for each line
			    lines.forEach(function(line, i) {
			      textEl.append("tspan")
			        .attr("x", textEl.attr("x"))
			        .attr("y", textEl.attr("y"))
			        .attr("dy", i === 0 ? "0em" : "1.2em")
			        .text(line);
			    });
			  });
			}

        </script>
    @endsection
</x-app-layout>
