<x-app-layout>
    @section('style')
    <style>

        .yellow-border {
            border-left: 5px solid #fcec60;
            background-color: #ecf0f1;
        }

        .yellow-border:hover {
            background-color: #fcec60;
        }

        .pink-border {
            border-left: 5px solid #eb739c;
            background-color: #ecf0f1;
        }

        .pink-border:hover {
            background-color: #eb739c;
        }


        .lgreen-border {
            border-left: 5px solid #bbe849;
            background-color: #ecf0f1;
        }

        .lgreen-border:hover {
            background-color: #bbe849;
        }

        .tabSelected{
            background-color: #2980b9 !important;
        }
        .yellow-bg {
            background-color: #fcec60;
        }

        .yellow-bg:hover {
            background-color: #f0d44a; /* Darker shade of yellow */
        }

        .pink-bg {
            background-color: #eb739c;
        }

        .pink-bg:hover {
            background-color: #d66f8b; /* Slightly darker pink */
        }

        .lgreen-bg {
            background-color: #bbe849;
        }

        .lgreen-bg:hover {
            background-color: #9bbf3e; /* Darker green */
        }

        /* The container holding all elements */
        #thesis-map-container {
            position: relative;
            width: 100%;
            height: 500px;
            /*border: 1px solid #ccc;*/
            overflow: hidden; /* Prevent dragging outside */
        }

        .label {
            position: absolute;
            font-size: 13px;
            font-weight: bold;
        }

        /* Draggable elements: milestones and obstacles */
        .draggable {
            width: 80px;
            height: 80px;
            line-height: 80px; /* Center text vertically */
            text-align: center;
            color: white;
            font-size: 12px;
            font-weight: bold;
            cursor: grab; /* Show the grab cursor */
            /*border: 1px solid black;*/
            position: absolute; /* Allow positioning within the container */
            user-select: none; /* Disable text selection while dragging */
        }

        .milestone {
            background-color: #fcec60;
            color: black;
            font-size: 9px;
        }

        .obstacle {
            background-color: #eb739c;
            color: black;
            font-size: 9px;
        }

        #startLabel {
            top: 50%;
            left: 10px;
          
            transform: translateY(-50%);
        }

        html {
    scroll-behavior: smooth;
}

        #completeLabel {
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            text-align: center;
        }
        #completeLabel img{
            width:80px;
            text-align: center;
            margin-bottom:10px;
            margin-left:18px;
        }

        #thesis {
            position: relative;
            overflow: hidden; /* This hides anything that goes outside the container */
            width: 100%;
            height: 100%;
        }

        #startLabel img{
            width:70px;
            text-align: center;
            margin-bottom:10px;
        }

        .fuel-section {
            position: relative;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            border-top: 2px solid #000;
            padding: 10px;
        }

        .fuel-label {
            display: flex;
            align-items: center;
            margin-right: 10px;
        }

        .fuel-icon {
            width: 60px;
            height: 60px;
        }

        .fuel {
            background-color: #bbe849;
            color: black;
            width: 80px;
            height: 80px;
            margin: 0 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            /*border: 2px solid #000;*/
            font-weight: bold;
            font-size: 9px;
            text-align: center;
        }

        #milestoneModal {
            display: none;
        }

    @media (max-width: 576px) {

        .mapbtn{
            font-size:7pt;
            display: block
        }

        #completeLabel {
        top: 50%;
        right: 8px;
        transform: translateY(-50%);
        text-align: center;
    }
    #completeLabel img {
        width: 60px;
        text-align: center;
        margin-bottom: 8px;
        margin-left: 12px;
    }

    #thesis {
        position: relative;
        overflow: hidden; /* This hides anything that goes outside the container */
        width: 100%;
        height: 100%;
    }

    #startLabel img {
        width: 50px;
        text-align: center;
        margin-bottom: 8px;
    }

    .fuel-section {
        position: relative;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 80px;
        background-color: #f5f5f5;
        display: flex;
        align-items: center;
        border-top: 2px solid #000;
        padding: 8px;
    }

    .fuel-label {
        display: flex;
        align-items: center;
        margin-right: 8px;
    }

    .fuel-icon {
        width: 40px;
        height: 40px;
    }

    .fuel {
        background-color: #bbe849;
        color: black;
        width: 60px;
        height: 60px;
        margin: 0 5px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 7px;
        text-align: center;
    }

    #milestoneModal {
        display: none;
    }
    
    }

  /* Reset default button styles for tabs */
  .tabsButton {
    background-color: transparent;
    border: none;
    border-bottom: 2px solid transparent;
    color: #007bff; /* Bootstrap primary color */
    padding: 10px;
    font-size: 1rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
  }
  
  /* Hover effect */
  .tabsButton:hover {
    background-color: #f8f9fa;
  }
  
  /* Active tab style */
  .tabsButton.tabSelected {
    border-bottom-color: #007bff;
    font-weight: bold;
    color: #007bff;
    color:white;
  }
</style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @endsection
    @section('headertitle')
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('messages.Thesis map', [], session()->get('applocale'))}}                                                
            </h2>
        </div>
       
    @endsection

    @section('maincontent')
    <div class="max-w-7xl mx-auto sm:px-8 mt-2 mb-2 lg:px-10">
    <div class="container">
    <div class="bg-white p-6 overflow-hidden mb-2 shadow-sm sm:rounded-lg">
            <p align="left">{!! __('messages.thesis_map_message', [], session()->get('applocale')) !!}<a class="c-blue" href="https://ahappyphd.org/posts/map-thesis/">{{ __('messages.this blog post', [], session()->get('applocale'))}}</a>.</p>
        </div>
        </div>
        </div>
        <!-- /////////////// THESIS MAP //////////////-->
        <div class="max-w-7xl mx-auto sm:px-8 mt-4 lg:px-10">
            <div class="container">
                <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="row d-block d-md-none mb-4 d-flex">
                         <div class="d-block d-md-none col-md-10 col-10 d-flex justify-content-end align-items-start"> 
                            <button id="saveMapButton2" class="d-block d-md-none mapbtn btn btn-block btn-info mt-2" onclick="savemap()"><i class="fa fa-save mr-2"></i>{{ __('messages.Save Map', [], session()->get('applocale'))}}</button>
                        </div>
                        <div class="col-md-2 col-2" style="display: flex; justify-content: flex-end; padding-right: 10px;">
                            <a href="#manageMapDiv" title="Manage the map"  class="mapbtn btn btn btn-secondary mt-2" ><i class="fa fa-cog"></i></a>
                        </div>
                       
                    </div>
                    <div class="row">
                        <!-- Left Part: Content (col-md-10) -->
                        <!-- Right Part: Button (col-md-2)onclick="addMilestone()" -->
                         
                        <div class="col-md-3 col-4 d-flex justify-content-end align-items-start">
                            <button class="mapbtn text-nowrap btn btn-block yellow-border mt-2" data-toggle="modal" data-target="#milestoneModal" >{{ __('messages.Add Milestone', [], session()->get('applocale'))}} +</button>
                        </div>
                        <div class="col-md-3 col-4 d-flex justify-content-end align-items-start">
                            <button class=" mapbtn text-nowrap btn btn-block pink-border mt-2"  data-toggle="modal" data-target="#obstacleModal">{{ __('messages.Add Obstacle', [], session()->get('applocale'))}} +</button>
                        </div>
                        <div class="col-md-3 col-4 d-flex justify-content-end align-items-start">
                            <button class="mapbtn btn text-nowrap btn-block lgreen-border mt-2" data-toggle="modal" data-target="#fuelModal">{{ __('messages.Add Fuel', [], session()->get('applocale'))}} +</button>
                        </div>
                        <div class="col-md-1 d-none d-md-block" style="display: flex; justify-content: flex-end; padding-right: 10px;">
                            <a href="#manageMapDiv" title="Manage the map"  class="mapbtn btn btn btn-secondary mt-2" ><i class="fa fa-cog"></i></a>
                        </div>
                        <div class="d-none d-md-block col-md-2  d-flex justify-content-end align-items-start"> 
                            <button id="saveMapButton" class="d-none d-md-block mapbtn btn btn-block btn-info mt-2" onclick="savemap()"><i class="fa fa-save mr-2"></i>{{ __('messages.Save Map', [], session()->get('applocale'))}}</button>
                        </div>

                    </div>
                    <div class="row mt-4">
                        <!--<div class="zoom-controls">
                            <button id="zoom-in" class="btn btn-sm btn-primary">+</button>
                            <button id="zoom-out" class="btn btn-sm btn-primary">-</button>
                        </div>-->
                    <div id="thesis" class="container">
        
                        <div id="thesis-map-container" class="canvas">
                            <!-- Start Thesis -->
                            <div id="startLabel" class="label">
                            <img src="/Template/assets/img/man.png" alt="">    
                            {{ __('messages.Start Thesis', [], session()->get('applocale'))}}</div>
                            <!-- Thesis Complete -->
                            
                            <div id="completeLabel" class="label">
                               
                            <img src="/Template/assets/img/graduation.png" alt="">    
                            {{ __('messages.Thesis Complete!', [], session()->get('applocale'))}}</div>
                            <!-- Buttons -->
                        </div>
                        </div>
                        <!-- Fuel Section -->
                        <div id="fuelSection" class="fuel-section">
                            <div class="fuel-label">
                                <img src="{{ asset('/Template/assets/img/fuel.png') }}" alt="Fuel" class="fuel-icon" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /////////////// END THESIS MAP //////////////-->
      <div id="manageMapDiv" class="max-w-7xl mx-auto sm:px-8 mt-4 lg:px-10">
  <div class="container">
    <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
      <div class="row mt-2" style="border-bottom:1px solid #2980b9">
        <div class="col-md-2 col-4 mb-2">
          <button id="milestonesTableButton" class="btn-block mapbtn tabsButton tabSelected" data-target="MilestonesTable">
            {{ __('messages.Milestones', [], session()->get('applocale')) }}
          </button>
        </div>
        <div class="col-md-2 col-4 mb-2">
          <button id="obstaclesTableButton" class="btn-block mapbtn tabsButton" data-target="ObstaclesTable">
            {{ __('messages.Obstacles', [], session()->get('applocale')) }}
          </button>
        </div>
        <div class="col-md-2 col-4 mb-2">
          <button id="fuelsTableButton" class="btn-block mapbtn tabsButton" data-target="FuelTable">
            {{ __('messages.Fuels', [], session()->get('applocale')) }}
          </button>
        </div>
        <div class="col-md-2 offset-md-4 mb-2 text-right">
          <!--<button id="refreshDataButton" class="btn btn-success" onclick="refreshData()"><i class="fa fa-sync" aria-hidden="true"></i></button>-->
        </div>
      </div>
      
      <div id="MilestonesTable" class="row mt-4">
        <div class="table-responsive">
          <table id="sortable-table-milestones" class="table table-hover m-4">
            <thead>
              <tr>
                <th class="text-nowrap">{{ __('messages.Order', [], session()->get('applocale')) }}</th>
                <th class="text-nowrap">{{ __('messages.Milestone', [], session()->get('applocale')) }}</th>
                <th class="text-nowrap">{{ __('messages.Created at', [], session()->get('applocale')) }}</th>
                <th class="text-nowrap">{{ __('messages.Finished at', [], session()->get('applocale')) }}</th>
                <th class="text-nowrap">{{ __('messages.Actions', [], session()->get('applocale')) }}</th>
              </tr>
            </thead>
            <tbody>
              <!-- Milestones data -->
            </tbody>
          </table>
        </div>
      </div>
      
      <div id="ObstaclesTable" class="row mt-4">
        <div class="table-responsive">
          <table id="sortable-table-obstacles" class="table table-hover m-4">
            <thead>
              <tr>
                <th class="text-nowrap">ID</th>
                <th class="text-nowrap">{{ __('messages.Obstacle', [], session()->get('applocale')) }}</th>
                <th class="text-nowrap">{{ __('messages.Actions', [], session()->get('applocale')) }}</th>
              </tr>
            </thead>
            <tbody>
              <!-- Obstacles data -->
            </tbody>
          </table>
        </div>
      </div>
      
      <div id="FuelTable" class="row mt-4">
        <div class="table-responsive">
          <table id="sortable-table-fuels" class="table table-hover m-4">
            <thead>
              <tr>
                <th class="text-nowrap">ID</th>
                <th class="text-nowrap">{{ __('messages.Fuel', [], session()->get('applocale')) }}</th>
                <th class="text-nowrap">{{ __('messages.Actions', [], session()->get('applocale')) }}</th>
              </tr>
            </thead>
            <tbody>
              <!-- Fuels data -->
            </tbody>
          </table>
        </div>
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
                        <button type="button" id="closeMilestoneModal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form to save the milestone -->
                        <form id="milestone-form" method="POST" action="{{ route('milestones.store') }}">
                            @csrf <!-- CSRF token for security -->
                            <!-- Milestone description -->
                            <div class="form-group">
                                <label for="milestone-input">{{ __('messages.Description', [], session()->get('applocale'))}}</label>
                                <textarea type="text" rows="5" class="form-control" id="milestone-input" name="milestone" placeholder="{{ __('messages.Enter your milestone', [], session()->get('applocale'))}}" required></textarea>
                            </div>
                            <!-- Hidden input for user ID if needed (assuming user is logged in) -->
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <input type="hidden" name="x_position" value="100">
                            <input type="hidden" name="y_position" value="100">
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.Cancel', [], session()->get('applocale'))}}</button>
                        <button type="submit" class="btn btn-success" id="save-milestone-btn">{{ __('messages.Save Milestone', [], session()->get('applocale'))}}</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Fuel Structure -->
        <div class="modal fade mt-4" id="fuelModal" tabindex="-1" role="dialog" aria-labelledby="fuelModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title h4" id="fuelModalLabel">{{ __('messages.Add New Fuel', [], session()->get('applocale'))}}</h3>
                        <button type="button"  id="closeFuelModal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form to save the fuel -->
                        <form id="fuel-form" method="POST" action="{{ route('fuels.store') }}">
                            @csrf <!-- CSRF token for security -->
                            
                            <!-- fuel description -->
                            <div class="form-group">
                                <label for="fuel-input">{{ __('messages.Description', [], session()->get('applocale'))}}</label>
                                <textarea type="text" rows="5" class="form-control" id="fuel-input" name="fuel" placeholder="{{ __('messages.Enter your fuel', [], session()->get('applocale'))}}" required></textarea>
                            </div>

                            <!-- Hidden input for user ID if needed (assuming user is logged in) -->
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        
                            <input type="hidden" name="x_position" value="100">
                            <input type="hidden" name="y_position" value="100">

                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.Cancel', [], session()->get('applocale'))}}</button>
                        <button type="submit" class="btn btn-success" id="save-fuel-btn">{{ __('messages.Save Fuel', [], session()->get('applocale'))}}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Obstacle Structure -->
        <div class="modal fade mt-4" id="obstacleModal" tabindex="-1" role="dialog" aria-labelledby="obstacleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title h4" id="obstacleModalLabel">{{ __('messages.Add New Obstacle', [], session()->get('applocale'))}}</h3>
                        <button type="button"  id="closeObstacleModal" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Form to save the fuel -->
                        <form id="obstacle-form" method="POST" action="{{ route('obstacles.store') }}">
                            @csrf <!-- CSRF token for security -->
                            
                            <!-- fuel description -->
                            <div class="form-group">
                                <label for="obstacle-input">{{ __('messages.Description', [], session()->get('applocale'))}}</label>
                                <textarea type="text" rows="5" class="form-control" id="obstacle-input" name="obstacle" placeholder="{{ __('messages.Enter your obstacle', [], session()->get('applocale'))}}" required></textarea>
                            </div>

                            <!-- Hidden input for user ID if needed (assuming user is logged in) -->
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        
                            <input type="hidden" name="x_position" value="100">
                            <input type="hidden" name="y_position" value="100">

                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.Cancel', [], session()->get('applocale'))}}</button>
                        <button type="submit" class="btn btn-success" id="save-obstacle-btn">{{ __('messages.Save Obstacle', [], session()->get('applocale'))}}</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Fuel Structure -->
        <div class="modal fade mt-4" id="editFuelModal" tabindex="-1" role="dialog" aria-labelledby="editFuelModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title h4" id="editFuelModalLabel">{{ __('messages.Edit Fuel', [], session()->get('applocale'))}}</h3>
                        <button type="button" class="close" onclick="closeModal('editFuelModal')"aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="edit-fuel-form" method="POST" action="{{ route('fuels.edit') }}">
                    @csrf <!-- CSRF token for security -->
                    <div class="modal-body">
                        <!-- Form to edit the fuel -->
                     
                         
                       

                            <!-- Milestone description -->
                            <div class="form-group">
                                <label for="edit-fuel-input">{{ __('messages.Description', [], session()->get('applocale'))}}</label>
                                <textarea type="text" rows="5" class="form-control" id="edit-fuel-input" name="description" placeholder="Edit your fuel" required></textarea>
                            </div>

                            <!-- Hidden input for fuel ID -->
                            <input type="hidden" id="edit-fuel-id" name="fuel_id">

                           
                      
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('editFuelModal')">{{ __('messages.Cancel', [], session()->get('applocale'))}}</button>
                        <button type="submit" class="btn btn-success" id="update-fuel-btn">{{ __('messages.Update Fuel', [], session()->get('applocale'))}}</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal Milestone Edit Structure -->
        <div class="modal fade mt-4" id="editMilestoneModal" tabindex="-1" role="dialog" aria-labelledby="editMilestoneModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title h4" id="editMilestoneModalLabel">Edit Milestone</h3>
                        <button type="button" class="close" onclick="closeModal('editMilestoneModal')"aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="edit-milestone-form" method="POST" action="{{ route('milestones.edit') }}">
                    @csrf <!-- CSRF token for security -->
                    <div class="modal-body">
                        <!-- Form to edit the milestone -->
                        <!-- Milestone description -->
                        <div class="form-group">
                            <label for="edit-milestone-input">{{ __('messages.Description', [], session()->get('applocale'))}}</label>
                            <textarea type="text" rows="5" class="form-control" id="edit-milestone-input" name="milestone" placeholder="Edit your milestone" required></textarea>
                        </div>
                        <!-- Hidden input for milestone ID -->
                        <input type="hidden" id="edit-milestone-id" name="milestone_id">

                        <label for="edit-milestone-finish" id="edit-milestone-finish-label">{{ __('messages.Finishing date', [], session()->get('applocale'))}}</label>
                        <input type="datetime-local" id="edit-milestone-finish" name="edit-milestone-finish">
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('editMilestoneModal')">{{ __('messages.Cancel', [], session()->get('applocale'))}}</button>
                        <button type="submit" class="btn btn-success" id="update-milestone-btn">{{ __('messages.Update Milestone', [], session()->get('applocale'))}}</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    
        <!-- Modal Obstacle Edit Structure -->
        <div class="modal fade mt-4" id="editObstacleModal" tabindex="-1" role="dialog" aria-labelledby="editObstacleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title h4" id="editObstacleModalLabel">{{ __('messages.Edit Obstacle', [], session()->get('applocale'))}}</h3>
                        <button type="button" class="close" onclick="closeModal('editObstacleModal')"aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="edit-obstacle-form" method="POST" action="{{ route('obstacles.edit') }}">
                    @csrf <!-- CSRF token for security -->
                    <div class="modal-body">
                        <!-- Form to edit the obstacle -->
                            <!-- Milestone description -->
                            <div class="form-group">
                                <label for="edit-obstacle-input">{{ __('messages.Description', [], session()->get('applocale'))}}</label>
                                <textarea type="text" rows="5" class="form-control" id="edit-obstacle-input" name="description" placeholder="Edit your obstacle" required></textarea>
                            </div>
                            <!-- Hidden input for obstacle ID -->
                            <input type="hidden" id="edit-obstacle-id" name="obstacle_id">
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('editObstacleModal')">{{ __('messages.Cancel', [], session()->get('applocale'))}}</button>
                        <button type="submit" class="btn btn-success" id="update-obstacle-btn">{{ __('messages.Update Obstacle', [], session()->get('applocale'))}}</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>


    @endsection

    @section('scripts')

    @if(session('obstacle_updated'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.scrollTo(100, document.body.scrollHeight);
            let button = document.getElementById("obstaclesTableButton");
            if (button) {
                setTimeout(function() {
                    button.click();
                }, 50);
            }
        });
    </script>
    @endif

    @if(session('fuel_updated'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            window.scrollTo(100, document.body.scrollHeight);
            let button = document.getElementById("fuelsTableButton");
            if (button) {
                setTimeout(function() {
                    button.click();
                }, 50);
            }
        });
    </script>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   
    <script>
        function closeModal(modalId) {
            var modalElement = document.getElementById(modalId);

            if (modalElement) {
                var modalInstance = bootstrap.Modal.getInstance(modalElement);  // Get the existing instance
                if (modalInstance) {
                    modalInstance.hide();  // Hide the modal
                    console.log('Modal hidden');
                } else {
                    console.error('Modal instance not found');
                }
            } else {
                console.error(`Modal with ID ${modalId} not found`);
            }

        }
      

        $(function () {
            // Make the table rows sortable
            $("#sortable-table-milestones tbody").sortable({
                update: function (event, ui) {
                    // Get the new order of rows
                    var order = $(this).sortable("toArray", { attribute: "data-id" });

                    $(this).find("tr").each(function (index) {
                        // Assuming the index column is in the first `td` element
                        $(this).find("td:first").html('<i class="fa fa-arrows mr-4"></i>' + (index + 1));
                    });

                    // Send the order to the server
                    $.ajax({
                        url: "{{ route('milestones.reorder') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            order: order
                        },
                        success: function (response) {
                            console.log(response.message);
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            }).disableSelection();
        });

        $(function () {
            // Make the table rows sortable
            $("#sortable-table-obstacles tbody").sortable({
                update: function (event, ui) {
                    // Get the new order of rows
                    var order = $(this).sortable("toArray", { attribute: "data-id" });

                    $(this).find("tr").each(function (index) {
                        // Assuming the index column is in the first `td` element
                        $(this).find("td:first").html('<i class="fa fa-arrows mr-4"></i>' + (index + 1));
                    });

                    // Send the order to the server
                    $.ajax({
                        url: "{{ route('obstacles.reorder') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            order: order
                        },
                        success: function (response) {
                            console.log(response.message);
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            }).disableSelection();
        });

        $(function () {
            // Make the table rows sortable
            $("#sortable-table-fuels tbody").sortable({
                update: function (event, ui) {
                    // Get the new order of rows
                    var order = $(this).sortable("toArray", { attribute: "data-id" });

                    $(this).find("tr").each(function (index) {
                        // Assuming the index column is in the first `td` element
                        $(this).find("td:first").html('<i class="fa fa-arrows mr-4"></i>' + (index + 1));
                    });

                    // Send the order to the server
                    $.ajax({
                        url: "{{ route('fuels.reorder') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            order: order
                        },
                        success: function (response) {
                            console.log(response.message);
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText);
                        }
                    });
                }
            }).disableSelection();
        });
    </script>
    <script>
        function openEditMilestoneModal(milestoneId, description, finishDate) {
            // Populate the modal fields with existing milestone data
            document.getElementById('edit-milestone-id').value = milestoneId;
            document.getElementById('edit-milestone-input').value = description;
           
            if(finishDate !== "null"){

                console.log('ah');
                console.log(finishDate);
                let finish= new Date(finishDate); // Current date
                let formattedDate =  finish.toISOString().slice(0, 16);
                document.getElementById('edit-milestone-finish').style.display = 'block';
                document.getElementById('edit-milestone-finish-label').style.display = 'block';
                document.getElementById('edit-milestone-finish').value = formattedDate;

            }else{
                console.log('la');
                console.log(finishDate);
                document.getElementById('edit-milestone-finish').style.display = 'none';  // Hide
                document.getElementById('edit-milestone-finish-label').style.display = 'none';
            }
            // Update the form action URL
            const form = document.getElementById('edit-milestone-form');
            form.action = `milestones/edit`;
            // Show the modal
            $('#editMilestoneModal').modal('show');
        }

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

        function finishObstacle(obstacleId) {
            // Confirm the action
            if (!confirm("Are you sure you want to mark this obstacle as finished?")) {
                return;
            }
            // Send an AJAX request
            fetch(`/obstacles/finish/${obstacleId}`, {
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

        function openEditObstacleModal(obstacleId, description) {
            // Populate the modal fields with existing milestone data
            document.getElementById('edit-obstacle-id').value = obstacleId;
            document.getElementById('edit-obstacle-input').value = description;

            // Update the form action URL
            const form = document.getElementById('edit-obstacle-form');
            form.action = `obstacles/edit`;

            // Show the modal
            $('#editObstacleModal').modal('show');
        }

        function openEditFuelModal(fuelId, description) {
            // Populate the modal fields with existing milestone data
            document.getElementById('edit-fuel-id').value = fuelId;
            document.getElementById('edit-fuel-input').value = description;

            // Update the form action URL
            const form = document.getElementById('edit-fuel-form');
            form.action = `fuels/edit`;

            // Show the modal
            $('#editFuelModal').modal('show');
        }
    </script>

    <script>
       /* document.addEventListener("DOMContentLoaded", () => {
            // Get references to the buttons and corresponding divs
            const buttons = document.querySelectorAll(".tabsButton");
            const divs = {
                Milestones: document.getElementById("MilestonesTable"),
                Obstacles: document.getElementById("ObstaclesTable"),
                Fuels: document.getElementById("FuelTable")
            };

            // Hide all divs except the first one (Milestones) initially
            for (const key in divs) {
                divs[key].style.display = key === "Milestones" ? "block" : "none";
            }

            // Add click event listeners to the buttons
            buttons.forEach(button => {
                button.addEventListener("click", () => {
                    // Remove 'tabSelected' class from all buttons
                    buttons.forEach(btn => btn.classList.remove("tabSelected"));
                    // Add 'tabSelected' class to the clicked button
                    button.classList.add("tabSelected");

                    // Show the corresponding div and hide others
                    const target = button.textContent.trim(); // Get the button text
                    for (const key in divs) {
                        divs[key].style.display = key === target ? "block" : "none";
                    }
                });
            });

           
        });
        */

        document.addEventListener("DOMContentLoaded", () => {
            const buttons = document.querySelectorAll(".tabsButton");
            const divs = {
                MilestonesTable: document.getElementById("MilestonesTable"),
                ObstaclesTable: document.getElementById("ObstaclesTable"),
                FuelTable: document.getElementById("FuelTable")
            };

         
            for (const key in divs) {
                divs[key].style.display = key === "MilestonesTable" ? "block" : "none";
            }

            buttons.forEach(button => {
                button.addEventListener("click", () => {
                    // Remove 'tabSelected' class from all buttons
                    buttons.forEach(btn => btn.classList.remove("tabSelected"));

                    // Add 'tabSelected' class to the clicked button
                    button.classList.add("tabSelected");

                    // Show the corresponding div and hide others
                    const target = button.getAttribute("data-target");
                    for (const key in divs) {
                        divs[key].style.display = key === target ? "block" : "none";
                    }
                });
            });
        });

    </script>

    <script>
        //console.log(Object.isFrozen(window)); 
        let milestoneCounter = 1;
        let obstacleCounter = 1;
        let fuelCounter = 1;
        let lastMilestonePosition = null;
        let lastMilestoneElement = null; //
        let lastObstacleElement = null; //
        let lastFuelElement = null; //

       /* let zoomLevel = 1;
        const zoomScale = 0.1;

        const container = document.getElementById('thesis-map-container');
        const thesisContainer = document.getElementById('thesis');

        // Zoom-in button event
        document.getElementById('zoom-in').addEventListener('click', () => {
            zoomLevel += zoomScale;
            updateZoom();
        });

        // Zoom-out button event
        document.getElementById('zoom-out').addEventListener('click', () => {
            zoomLevel = Math.max(zoomLevel - zoomScale, 0.1); // Prevent zooming out too much
            updateZoom();
        });

        function updateZoom() {
            container.style.transform = `scale(${zoomLevel})`;
            container.style.transformOrigin = 'top left'; // Keep the origin of scaling at the top-left corner
            adjustElementsPosition();
        }

        let isDragging = false;
        let startX, startY;
        let offsetX = 0, offsetY = 0;

        // Start dragging when clicking inside the container (but not on draggable items)
        container.addEventListener('mousedown', (e) => {
            // Check if the click target is a draggable element
            const target = e.target;
            if (target.classList.contains('draggable')) {
                return; // Don't start dragging the container if the click is on a draggable item
            }

            // Only start dragging when clicking in the container
            isDragging = true;
            startX = e.pageX - offsetX;
            startY = e.pageY - offsetY;
            container.style.cursor = 'move'; // Change the cursor to indicate dragging
        });

        // Dragging movement
        container.addEventListener('mousemove', (e) => {
            if (!isDragging) return;

            e.preventDefault(); // Prevent selection while dragging

            const dx = e.pageX - startX;
            const dy = e.pageY - startY;

            // Update the translation based on zoom level
            offsetX = dx / zoomLevel;
            offsetY = dy / zoomLevel;

            // Apply the translation to the container with respect to zoom level
            container.style.transform = `scale(${zoomLevel}) translate(${offsetX}px, ${offsetY}px)`;
        });

        // Stop dragging when the mouse is released
        container.addEventListener('mouseup', () => {
            isDragging = false;
            container.style.cursor = 'default'; // Reset the cursor when dragging stops
        });

        // Optional: If you want to make sure dragging only works when mouse is down inside the container (and not on a draggable element), use this:
        container.addEventListener('mouseleave', () => {
            if (isDragging) {
                isDragging = false;
                container.style.cursor = 'default';
            }
        });



        function adjustElementsPosition() {
            // This function will adjust the positions of the existing elements based on the zoom level
            const milestones = document.querySelectorAll('.milestone');
            const obstacles = document.querySelectorAll('.obstacle');
            milestones.forEach(milestone => {
                const originalX = parseFloat(milestone.getAttribute('data-x'));
                const originalY = parseFloat(milestone.getAttribute('data-y'));

                // Adjust position by zoom level
                milestone.style.left = `${originalX * zoomLevel - 50}px`;
                milestone.style.top = `${originalY * zoomLevel - 50}px`;
            });

            obstacles.forEach(obstacle => {
                const originalX = parseFloat(obstacle.getAttribute('data-x'));
                const originalY = parseFloat(obstacle.getAttribute('data-y'));

                // Adjust position by zoom level
                obstacle.style.left = `${originalX * zoomLevel - 50}px`;
                obstacle.style.top = `${originalY * zoomLevel - 50}px`;
            });
        }*/

        const existingMilestones = @json($milestones);
        const existingObstacles = @json($obstacles);
        const existingFuels = @json($fuels);

        document.addEventListener('DOMContentLoaded', () => {
            refreshMilestones();
            refreshObstacles();
            refreshFuels();
            refreshData();
        });

        function refreshMilestones() {
            console.log('Refreshing Milestones...');
            fetch('{{ route('milestones.data') }}')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#sortable-table-milestones tbody');
                    tableBody.innerHTML = ''; // Clear current rows
                    data.forEach((milestone, index) => {
                        const row = `
                            <tr class="text-nowrap" data-id="${milestone.id}">
                                <td class="text-nowrap"><i class="fa fa-arrows mr-4"></i>${index + 1}</td>
                                <td class="text-nowrap">${milestone.milestone}</td>
                                <td class="text-nowrap">${new Date(milestone.created_at).toLocaleString()}</td>
                                <td class="text-nowrap">${milestone.finished_at ? new Date(milestone.finished_at).toLocaleString() : 'In progress...'}</td>
                                <td class="text-nowrap col-md-3 d-flex justify-content-start align-items-center">
                                    <button  style="min-width: 100px" class="btn btn-sm mx-1 ${milestone.finished_at ? 'disabled btn-secondary' : 'btn-success'}" onclick="finishMilestone(${milestone.id})">
                                       
                                        ${milestone.finished_at ? '{{ __("messages.Finished", [], session()->get("applocale"))}}' : ' <i class="fa fa-flag-checkered mr-2"></i>{{ __("messages.Finish", [], session()->get("applocale"))}}'}
                                        
                                    </button>
                                    <button class="btn btn-sm btn-warning mx-1" onclick="openEditMilestoneModal(${milestone.id}, '${milestone.milestone.replace(/'/g, "\\'")}', '${milestone.finished_at}')">
                                        <i class="fa fa-edit mr-2"></i>{{ __('messages.Edit', [], session()->get('applocale'))}}
                                    </button>
                                    <form action="/milestones/remove/${milestone.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this milestone?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger mx-1"><i class="fa fa-trash mr-2"></i>{{ __('messages.Delete', [], session()->get('applocale'))}}</button>
                                    </form>
                                </td>
                            </tr>`;
                        tableBody.innerHTML += row;
                    });
                });
                console.log('Milestones refreshed!');
        }

        // Repeat for Obstacles and Fuels
        function refreshObstacles() {
            console.log('Refreshing Obstacles...');
            fetch('{{ route('obstacles.data') }}')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#sortable-table-obstacles tbody');
                    tableBody.innerHTML = '';
                    data.forEach((obstacle, index) => {
                        const row = `
                            <tr  data-id="${obstacle.id}">
                                <td class="text-nowrap">${index + 1}</td>
                                <td class="text-nowrap">${obstacle.description}</td>
                                <td class="text-nowrap col-md-2 d-flex justify-content-start align-items-center">
                                    <button class="btn btn-sm btn-warning mx-1" onclick="openEditObstacleModal(${obstacle.id}, '${obstacle.description.replace(/'/g, "\\'")}')">
                                        <i class="fa btn-sm fa-edit"></i>{{ __('messages.Edit', [], session()->get('applocale'))}}
                                    </button>
                                    <form action="/obstacles/remove/${obstacle.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this obstacle?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger mx-1"><i class="fa fa-trash mr-2"></i>{{ __('messages.Delete', [], session()->get('applocale'))}}</button>
                                    </form>
                                </td>
                            </tr>`;
                        tableBody.innerHTML += row;
                    });
                });
        }

        function refreshFuels() {
            console.log('Refreshing Fuels...');
            fetch('{{ route('fuels.data') }}')
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.querySelector('#sortable-table-fuels tbody');
                    tableBody.innerHTML = '';
                    data.forEach((fuel, index) => {
                        const row = `
                            <tr  data-id="${fuel.id}">
                                <td class="text-nowrap">${index + 1}</td>
                                <td class="text-nowrap">${fuel.description}</td>
                                <td class="text-nowrap col-md-2 d-flex justify-content-start align-items-center">
                                    <button class="btn btn-sm btn-warning mx-1" onclick="openEditFuelModal(${fuel.id}, '${fuel.description.replace(/'/g, "\\'")}')">
                                        <i class="fa fa-edit mr-2"></i>{{ __('messages.Edit', [], session()->get('applocale'))}}
                                    </button>
                                    <form action="/fuels/remove/${fuel.id}" method="POST" onsubmit="return confirm('Are you sure you want to delete this fuel?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger mx-1"><i class="fa fa-trash mr-2"></i>{{ __('messages.Delete', [], session()->get('applocale'))}}</button>
                                    </form>
                                </td>
                            </tr>`;
                        tableBody.innerHTML += row;
                    });
                });
        }



        function refreshData(){
            console.log('Refreshing data...');
            refreshMilestones();
            refreshObstacles();
            refreshFuels();
            console.log('Data refreshed');
        }

 

        refreshMilestones();
        refreshObstacles();
        refreshFuels();

         // Get the position of an element relative to its container
        function getElementPosition(element, container) {
            
            const rect = element.getBoundingClientRect();
            const containerRect = container.getBoundingClientRect();

            if (!element) {
                console.error("The provided element is null or undefined.");
                return null; // or a default position
            }

            if (!container) {
                console.error("The provided container is null or undefined.");
                return null; // or a default position
            }
            return {
                x: rect.left - containerRect.left + rect.width / 2,
                y: rect.top - containerRect.top + rect.height / 2
            };
        }

        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('thesis-map-container');
            existingMilestones.forEach(milestone => {
                let finish = !!milestone.finished_at;
                addExistingMilestone(milestone.name, milestone.x_position, milestone.y_position, milestone.milestone, finish);
               
            });
            existingObstacles.forEach(obstacle => {
                addExistingObstacle(obstacle.obstacle, obstacle.position_x, obstacle.position_y, obstacle.description);
               
            });

            existingFuels.forEach(fuel => {
                addExitingFuel(fuel.fuel, fuel.description);
               
            });

           
        });

        //----------------------------------------------//  MILESTONE MODAL SAVE     //----------------------------------------------//
        document.getElementById('save-milestone-btn').addEventListener('click', function () {
            // Collect form data
            const form = document.getElementById('milestone-form');
      
            const formData = new FormData(form);
            formData.append('milestoneCounter', milestoneCounter);
            // Make AJAX request
            fetch('/milestones/store', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Ensures the server knows it's an AJAX request
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // Include CSRF token if using Laravel
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
               
            })
            .then(data => {
                console.log('Success:', data);
                // Add additional logic if needed, e.g., updating the UI

             
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle errors, e.g., show an alert to the user
            });
           
           
            //$('#milestoneModal').modal('hide'); 
            var modal = new bootstrap.Modal(document.getElementById('milestoneModal'));
            modal.hide();

            var closeModalButton = document.getElementById('closeMilestoneModal');
            closeModalButton.click();
            
            $('.modal-backdrop').remove();
            //closeModal('milestoneModal');
            addMilestone();
            
            setTimeout(() => {
                 refreshMilestones();
            }, 500);
           
        
            //console.log(milestoneCounter);
        });

       

        //----------------------------------------------//  OBSTACLE MODAL SAVE     //----------------------------------------------//
        document.getElementById('save-obstacle-btn').addEventListener('click', function () {
            // Collect form data
            const form = document.getElementById('obstacle-form');
      
            const formData = new FormData(form);
            formData.append('obstacleCounter', obstacleCounter);
            // Make AJAX request
            fetch('/obstacles/store', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Ensures the server knows it's an AJAX request
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // Include CSRF token if using Laravel
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
               
            })
            .then(data => {
                console.log('Success:', data);
                // Add additional logic if needed, e.g., updating the UI
             
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle errors, e.g., show an alert to the user
            });
            
           // $('#obstacleModal').modal('hide'); 

            var modal = new bootstrap.Modal(document.getElementById('obstacleModal'));
            modal.hide();

            var closeModalButton = document.getElementById('closeObstacleModal');
            closeModalButton.click();

            $('.modal-backdrop').remove();
            //closeModal('obstacleModal');
            addObstacle();
         
            
  
            setTimeout(() => {
                 refreshObstacles();
            }, 500);
            //console.log(milestoneCounter);
        });

         //----------------------------------------------//  FUEL MODAL SAVE     //----------------------------------------------//

        document.getElementById('save-fuel-btn').addEventListener('click', function () {
            // Collect form data
            const form = document.getElementById('fuel-form');
      
            const formData = new FormData(form);
            formData.append('fuelCounter', fuelCounter);
            // Make AJAX request
            fetch('/fuels/store', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest', // Ensures the server knows it's an AJAX request
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content // Include CSRF token if using Laravel
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
               
            })
            .then(data => {
                console.log('Success:', data);
                // Add additional logic if needed, e.g., updating the UI
             
            })
            .catch(error => {
                console.error('Error:', error);
                // Handle errors, e.g., show an alert to the user
            });
            
            //$('#fuelModal').modal('hide'); 

            var modal = new bootstrap.Modal(document.getElementById('fuelModal'));
            modal.hide();

            var closeModalButton = document.getElementById('closeFuelModal');
            closeModalButton.click();

            $('.modal-backdrop').remove();
            addFuel();

            setTimeout(() => {
                 refreshFuels();
            }, 500);
            
            //console.log(milestoneCounter);
        });

        function addExitingFuel(fuel, description) {
            const fuelSection = document.getElementById("fuelSection");

                if (fuelCounter <= 15) { // Limit fuel count to 5
                    const fuel = document.createElement("div");
                    fuel.className = "fuel";
                    
                 /*   fuel.style.width = '100%';              // Make sure it covers the full width
                    fuel.style.maxWidth = '100px';          // Optional: Set a maximum width if desired
                    fuel.style.overflow = 'hidden';         // Prevent text overflow
                    fuel.style.whiteSpace = 'nowrap';       // Prevent text wrapping
                    fuel.style.textOverflow = 'ellipsis';   // Add ellipsis if text exceeds width
                    fuel.style.boxSizing = 'border-box'; */

                    fuel.setAttribute("id", `${fuel}`);
                    //fuel.innerHTML =  description.substring(0, 10);
                    fuelSection.appendChild(fuel);

                    const maxWords = 3; // Number of words to show

                    function truncateToWords(str, numWords) {
                    const words = str.split(' ');
                    if (words.length <= numWords) {
                        return str;
                    }
                    return words.slice(0, numWords).join(' ') + '...';
                    }

                    const truncatedDescription = truncateToWords(description, maxWords);

                
                    fuel.innerHTML = truncatedDescription;
                    fuel.style.lineHeight = '1.2';
                    fuel.style.padding = '9px';
                    fuel.style.textAlign = 'center'; // Centers the text horizontally
                    fuel.style.display = 'flex'; // Allows centering in both directions
                    fuel.style.alignItems = 'center'; // Vertically centers the text
                    fuel.style.justifyContent = 'center'; // Horizontally centers the text
                    fuel.title = description; // Horizontally centers the text

            
                        /* const removeButton = document.createElement('button');
                            removeButton.textContent = 'X';
                            removeButton.style.position = 'relative';
                            removeButton.style.top = '-20px';
                            removeButton.style.right = '-2px';
                            removeButton.style.background = 'lightgrey';
                            removeButton.style.color = 'black';
                            removeButton.style.border = 'none';
                            removeButton.style.borderRadius = '50%';
                            removeButton.style.width = '15px';
                            removeButton.style.height = '15px';
                            removeButton.style.cursor = 'pointer';

                            // Center the "X" inside the button
                            removeButton.style.display = 'flex';
                            removeButton.style.justifyContent = 'center';
                            removeButton.style.alignItems = 'center';
                            removeButton.style.padding = '0';
                            removeButton.style.lineHeight = 'normal';
                            removeButton.style.fontSize = '9px';
                            removeButton.onclick = function () {
                                removeFuel(fuel.id);
                            };
                            fuel.appendChild(removeButton);
                        */

                    lastFuelElement = fuel;
                    fuelCounter++;

                } else {
                    alert("Maximum fuel reached!");
                }
        };

        function addExistingObstacle(name, x, y, description) {
            const container = document.getElementById('thesis-map-container');
            const newObstacle = document.createElement('div');
            newObstacle.className = 'draggable obstacle';

            const maxWords = 7; // Number of words to show

            function truncateToWords(str, numWords) {
            const words = str.split(' ');
            if (words.length <= numWords) {
                return str;
            }
            return words.slice(0, numWords).join(' ') + '...';
            }

            const truncatedDescription = truncateToWords(description, maxWords);

            newObstacle.className = 'draggable obstacle';
            newObstacle.textContent = truncatedDescription;
            newObstacle.style.lineHeight = '1.2';
            newObstacle.style.padding = '10px';
            newObstacle.style.textAlign = 'center'; // Centers the text horizontally
            newObstacle.style.display = 'flex'; // Allows centering in both directions
            newObstacle.style.alignItems = 'center'; // Vertically centers the text
            newObstacle.style.justifyContent = 'center'; // Horizontally centers the text

            newObstacle.title = description;

        

           
            newObstacle.style.left = `${x-50}px`;
            newObstacle.style.top = `${y-50}px`;
            newObstacle.setAttribute("id", `${name}`);

            /*
            const removeButton = document.createElement('button');
            removeButton.textContent = 'X';
            removeButton.style.position = 'absolute';
            removeButton.style.top = '5px';
            removeButton.style.right = '5px';
            removeButton.style.background = 'lightgrey';
            removeButton.style.color = 'black';
            removeButton.style.border = 'none';
            removeButton.style.borderRadius = '50%';
            removeButton.style.width = '20px';
            removeButton.style.height = '20px';
            removeButton.style.cursor = 'pointer';

            // Center the "X" inside the button
            removeButton.style.display = 'flex';
            removeButton.style.justifyContent = 'center';
            removeButton.style.alignItems = 'center';
            removeButton.style.padding = '0';
            removeButton.style.lineHeight = 'normal';
            removeButton.style.fontSize = '9px';
            removeButton.onclick = function () {
                removeObstacle(newObstacle.id);
            };
            newObstacle.appendChild(removeButton);*/

           
            container.appendChild(newObstacle);

            lastObstacleElement = newObstacle;

            makeMovable(newObstacle);
            obstacleCounter++;
        }

         // Add milestones dynamically and link them
        function addExistingMilestone(name, x, y, description, finish) {
            const container = document.getElementById('thesis-map-container');
            const newMilestone = document.createElement('div');
           
            const firstPosition = getElementPosition(startLabel, container);
            const completePosition = getElementPosition(completeLabel, container);
          
            const lineId = 'line-0';
            const lineId2 = 'line-1';

            const firstLine = 'line-first';
            const lastLine = 'line-last';

            const maxWords = 7; // Number of words to show

            function truncateToWords(str, numWords) {
            const words = str.split(' ');
            if (words.length <= numWords) {
                return str;
            }
            return words.slice(0, numWords).join(' ') + '...';
            }

            const truncatedDescription = truncateToWords(description, maxWords);

            newMilestone.className = 'draggable milestone';
            newMilestone.textContent = truncatedDescription;
            newMilestone.style.lineHeight = '1.2';
            newMilestone.style.padding = '10px';
            newMilestone.style.textAlign = 'center'; // Centers the text horizontally
            newMilestone.style.display = 'flex'; // Allows centering in both directions
            newMilestone.style.alignItems = 'center'; // Vertically centers the text
            newMilestone.style.justifyContent = 'center'; // Horizontally centers the text
            newMilestone.title = description;
       
       
            const finishedMilestone = document.createElement('button');
            finishedMilestone.innerHTML = '<i class="fa fa-check" aria-hidden="true"></i>';
            finishedMilestone.style.position = 'absolute';
            finishedMilestone.style.top = '5px';
            finishedMilestone.style.right = '5px';
            finishedMilestone.style.background = '#00b389';
            finishedMilestone.style.color = 'white';
            finishedMilestone.style.border = 'none';
            finishedMilestone.style.borderRadius = '50%';
            finishedMilestone.style.width = '20px';
            finishedMilestone.style.height = '20px';
            finishedMilestone.style.cursor = 'grab';

            finishedMilestone.style.display = 'flex';
            finishedMilestone.style.justifyContent = 'center';
            finishedMilestone.style.alignItems = 'center';
            finishedMilestone.style.padding = '0';
            finishedMilestone.style.lineHeight = 'normal';
            finishedMilestone.style.fontSize = '9px';
            

            // Draw a line from the last milestone to the new one
            if (name == "milestone-1"){
                //console.log('creating milestone 1');
                // Append the "X" button to the milestone
                if(finish){
                    newMilestone.appendChild(finishedMilestone);
                }

                newMilestone.style.left = `${x-50}px`;
                newMilestone.style.top = `${y-50}px`;
                newMilestone.style.position = 'absolute';
                newMilestone.setAttribute("id", `${name}`);
                container.appendChild(newMilestone);
                

                const newPosition = getElementPosition(newMilestone, container);
                drawLine(
                    firstPosition.x,
                    firstPosition.y,
                    newPosition.x,
                    newPosition.y,
                    firstLine
                );

                drawLine(
                    newPosition.x,
                    newPosition.y,
                    completePosition.x,
                    completePosition.y,
                    lastLine
                );
            }
            else{
                //console.log('creating another milestone');
                const lineId = `line-${milestoneCounter}`;
                const lineId2 = `line-${milestoneCounter+1}`;

                // Append the "X" button to the milestone
                if(finish){
                    newMilestone.appendChild(finishedMilestone);
                }

                //var px = milestoneCounter*10+ 100;
                newMilestone.style.left = `${x-50}px`;
                newMilestone.style.top = `${y-50}px`;
                newMilestone.style.position = 'absolute';
                newMilestone.setAttribute("id", `${name}`);
                container.appendChild(newMilestone);

               
                const lastPosition = getElementPosition(lastMilestoneElement, container);
                const newPosition = getElementPosition(newMilestone, container);
                removeLine(lastLine);
             

                drawLine(
                    lastPosition.x,
                    lastPosition.y,
                    newPosition.x,
                    newPosition.y,
                    lineId
                );

                drawLine(
                    newPosition.x,
                    newPosition.y,
                    completePosition.x,
                    completePosition.y,
                    lastLine
                );

               

               // console.log(px);
            }
            

            lastMilestoneElement = newMilestone; // Update the last milestone
           
            makeMovable(newMilestone);
            milestoneCounter++; // Increment counter
        }

        function savemap() {
            const container = document.getElementById('thesis-map-container');
            const saveButton = document.getElementById('saveMapButton'); // Select the save button
             const saveButton2 = document.getElementById('saveMapButton2'); // Select the save button

            // Change button appearance to indicate success
            saveButton.classList.remove('btn-info');
            saveButton.classList.add('bg-light-green');
            saveButton.innerHTML = '<i class="fa fa-check mr-2"></i>Saved'; // Update icon and text

             // Change button appearance to indicate success
            saveButton2.classList.remove('btn-info');
            saveButton2.classList.add('bg-light-green');
            saveButton2.innerHTML = '<i class="fa fa-check mr-2"></i>Saved'; // Update icon and text

            // Revert button appearance after 3 seconds
            setTimeout(() => {
                saveButton.classList.remove('bg-light-green');
                saveButton.classList.add('btn-info');
                saveButton.innerHTML = '<i class="fa fa-save mr-2"></i>{{ __("messages.Save Map", [], session()->get("applocale")) }}';
                  saveButton2.classList.remove('bg-light-green');
                saveButton2.classList.add('btn-info');
                saveButton2.innerHTML = '<i class="fa fa-save mr-2"></i>{{ __("messages.Save Map", [], session()->get("applocale")) }}';
            }, 1000);

            for (let i = 1; i <= milestoneCounter - 1; i++) {
                var milestoneId = `milestone-${i}`;
                var milestone = document.getElementById(milestoneId);

                if (milestone) {
                    const milestonePosition = getElementPosition(milestone, container);
                    let position_x = Math.floor(milestonePosition.x);
                    let position_y = Math.floor(milestonePosition.y);
                    console.log('position X');
                    console.log(position_x);
                    console.log('position y');
                    console.log(position_y);
                    // Prepare data for AJAX request
                    const formData = new FormData();
                    formData.append('id', milestoneId); // Remove 'milestone-' prefix to get the ID
                    formData.append('position_x', position_x + 9);
                    formData.append('position_y', position_y + 9);

                    // Send AJAX request to update the milestone position
                    fetch('/milestones/update', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, // CSRF Token
                        },
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log(`Milestone ${milestoneId} position updated successfully!`);
                            } else {
                                console.error(`Failed to update milestone ${milestoneId}:`, data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error updating milestone position:', error);
                        });
                } else {
                    console.log(`Milestone ${milestoneId} not found.`);
                }
            }

            for (let i = 1; i <= obstacleCounter - 1; i++) {
                var obstacleId = `obstacle-${i}`;
                var obstacle = document.getElementById(obstacleId);

                if (obstacle) {
                    const obstaclePosition = getElementPosition(obstacle, container);
                    let position_x = Math.floor(obstaclePosition.x);
                    let position_y = Math.floor(obstaclePosition.y);
                    console.log('position X');
                    console.log(position_x);
                    console.log('position y');
                    console.log(position_y);
                    // Prepare data for AJAX request
                    const formData = new FormData();
                    formData.append('id', obstacleId); // Remove 'milestone-' prefix to get the ID
                    formData.append('position_x', position_x + 9);
                    formData.append('position_y', position_y + 9);

                    // Send AJAX request to update the milestone position
                    fetch('/obstacles/update', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, // CSRF Token
                        },
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log(`Obstacle ${obstacleId} position updated successfully!`);
                            } else {
                                console.error(`Failed to update milestone ${obstacleId}:`, data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error updating Obstacle position:', error);
                        });
                } else {
                    console.log(`Milestone ${obstacleId} not found.`);
                }
            }
        }

        // Add milestones dynamically and link them
        function addMilestone() {
            const container = document.getElementById('thesis-map-container');
            const newMilestone = document.createElement('div');
           
            const firstPosition = getElementPosition(startLabel, container);
            const completePosition = getElementPosition(completeLabel, container);
          
            const lineId = 'line-0';
            const lineId2 = 'line-1';

            const firstLine = 'line-first';
            const lastLine = 'line-last';

            const newMilestoneName = document.getElementById('milestone-input').value;

            newMilestone.className = 'draggable milestone';
            newMilestone.style.lineHeight = '1.2';
            newMilestone.style.padding = '10px';
            newMilestone.style.textAlign = 'center'; // Centers the text horizontally
            newMilestone.style.display = 'flex'; // Allows centering in both directions
            newMilestone.style.alignItems = 'center'; // Vertically centers the text
            newMilestone.style.justifyContent = 'center'; // Horizontally centers the text
       
            

            const maxWords = 7; // Number of words to show

            function truncateToWords(str, numWords) {
            const words = str.split(' ');
            if (words.length <= numWords) {
                return str;
            }
            return words.slice(0, numWords).join(' ') + '...';
            }

            const truncatedDescription = truncateToWords(newMilestoneName, maxWords);


            newMilestone.textContent = truncatedDescription; 
        
            newMilestone.title = newMilestoneName; 

                // Create the "X" button
                /* const removeButton = document.createElement('button');
                    removeButton.textContent = 'X';
                    removeButton.style.position = 'absolute';
                    removeButton.style.top = '5px';
                    removeButton.style.right = '5px';
                    removeButton.style.background = 'lightgrey';
                    removeButton.style.color = 'white';
                    removeButton.style.border = 'none';
                    removeButton.style.borderRadius = '50%';
                    removeButton.style.width = '20px';
                    removeButton.style.height = '20px';
                    removeButton.style.cursor = 'pointer';

                    // Center the "X" inside the button
                    removeButton.style.display = 'flex';
                    removeButton.style.justifyContent = 'center';
                    removeButton.style.alignItems = 'center';
                    removeButton.style.padding = '0';
                    removeButton.style.lineHeight = 'normal';
                    removeButton.style.fontSize = '9px';
                    removeButton.onclick = function () {
                        removeMilestone(newMilestone.id);
                    };
                */

            // Draw a line from the last milestone to the new one
            if (lastMilestoneElement) {
                const lineId = `line-${milestoneCounter}`;
                const lineId2 = `line-${milestoneCounter+1}`;
                const lastPosition = getElementPosition(lastMilestoneElement, container);

                // Append the "X" button to the milestone
                /*newMilestone.appendChild(removeButton);*/

                var px = milestoneCounter*10+ 100;
                newMilestone.style.left = `${lastPosition.x+10}px`;
                newMilestone.style.top = `${lastPosition.y+10}px`;
                newMilestone.style.position = 'absolute';
                newMilestone.setAttribute("id", `milestone-${milestoneCounter}`);
                container.appendChild(newMilestone);

              
                const newPosition = getElementPosition(newMilestone, container);
                removeLine(lastLine);
             

                drawLine(
                    lastPosition.x,
                    lastPosition.y,
                    newPosition.x,
                    newPosition.y,
                    lineId
                );

                drawLine(
                    newPosition.x,
                    newPosition.y,
                    completePosition.x,
                    completePosition.y,
                    lastLine
                );

               

                //console.log(px);
            }
            else{
                // Append the "X" button to the milestone
               /* newMilestone.appendChild(removeButton);*/

                newMilestone.style.left = '100px';
                newMilestone.style.top = '100px';
                newMilestone.style.position = 'absolute';
                newMilestone.setAttribute("id", `milestone-${milestoneCounter}`);
                container.appendChild(newMilestone);

                const newPosition = getElementPosition(newMilestone, container);
                drawLine(
                    firstPosition.x,
                    firstPosition.y,
                    newPosition.x,
                    newPosition.y,
                    firstLine
                );

                drawLine(
                    newPosition.x,
                    newPosition.y,
                    completePosition.x,
                    completePosition.y,
                    lastLine
                );
               
               
            }

             lastMilestoneElement = newMilestone;
             // Update the last milestone
            milestoneCounter++; // Increment counter
            makeMovable(newMilestone);
            document.getElementById('milestone-input').value = '';


            setTimeout(() => {
                $('#refreshDataButton').click();
            }, 5000);


        }

        //startLabel
        function removeMilestone(id) {
            const container = document.getElementById('thesis-map-container');
            const userConfirmed = confirm(`Are you sure you want to remove this milestone ${id} ?` );
            if (userConfirmed) {
                console.log('Child removed');
                console.log(id);

                // Get the DOM element to remove
                const milestoneElement = document.getElementById(id);
                const milestoneIdNumber = parseInt(id.split('-')[1], 10);
                if (!milestoneElement) {
                    console.error(`Milestone with ID "${id}" not found.`);
                    return;
                }

                const previousMilestoneId = `milestone-${milestoneIdNumber-1}`;
                const previousMilestoneElement = document.getElementById(previousMilestoneId);

                // Get the last milestone's ID number
                
                if (!lastMilestoneElement) {
                    console.error('No milestones found in the container.');
                    return;
                }
                const lastMilestoneIdNumber = parseInt(lastMilestoneElement.id.split('-')[1], 10);

                console.log(milestoneIdNumber);
                console.log(lastMilestoneIdNumber);

                if (milestoneElement === lastMilestoneElement) {
                   
                    //console.log(lastMilestoneElement);
                    let newLastMilestoneElement = document.getElementById(`milestone-${milestoneIdNumber - 1}`);
                    lastMilestoneElement = newLastMilestoneElement;
                   
                    removeLine('line-last');
                    removeLine(`line-${milestoneIdNumber}`);
                    const completePosition = getElementPosition(completeLabel, container);
                    const elementPosition = getElementPosition(newLastMilestoneElement, container);
                    const lastLine = 'line-last';
                    drawLine(
                        elementPosition.x,
                        elementPosition.y,
                        completePosition.x,
                        completePosition.y,
                        lastLine
                    );

                    container.removeChild(milestoneElement);
                    console.log(lastMilestoneElement);
                    milestoneCounter--;

                }
                else if(milestoneIdNumber == 1){
                      //console.log(lastMilestoneElement);
                    let newFirstMilestoneElement = document.getElementById(`milestone-${milestoneIdNumber + 1}`);

                    removeLine('line-first');
                    removeLine(`line-${milestoneIdNumber + 1}`);
                    const startPosition = getElementPosition(startLabel, container);
                    const elementPosition = getElementPosition(newFirstMilestoneElement, container);
                    const firstLine = 'line-first';
                    drawLine(
                        startPosition.x,
                        startPosition.y,
                        elementPosition.x,
                        elementPosition.y,
                        firstLine
                    );

                    container.removeChild(milestoneElement);

                    for (let i = 2; i <= lastMilestoneIdNumber; i++) {
                        // Update milestone ID
                        const currentMilestone = document.getElementById(`milestone-${i}`);
                        if (currentMilestone) {
                            currentMilestone.id = `milestone-${i - 1}`;
                            currentMilestone.textContent = `Milestone ${i - 1}`; // Update content
                        
                        /*

                            const removeButton = document.createElement('button');
                            removeButton.textContent = 'X';
                            removeButton.style.position = 'absolute';
                            removeButton.style.top = '5px';
                            removeButton.style.right = '5px';
                            removeButton.style.background = 'lightgrey';
                            removeButton.style.color = 'white';
                            removeButton.style.border = 'none';
                            removeButton.style.borderRadius = '50%';
                            removeButton.style.width = '20px';
                            removeButton.style.height = '20px';
                            removeButton.style.cursor = 'pointer';

                            // Center the "X" inside the button
                            removeButton.style.display = 'flex';
                            removeButton.style.justifyContent = 'center';
                            removeButton.style.alignItems = 'center';
                            removeButton.style.padding = '0';
                            removeButton.style.lineHeight = 'normal';
                            removeButton.style.fontSize = '9px';
                            removeButton.onclick = function () {
                                removeMilestone(currentMilestone.id);
                            };

                            currentMilestone.appendChild(removeButton);
                            */
                        }

                        // Update line ID
                        const currentLine = document.getElementById(`line-${i}`);
                        if (currentLine) {
                            currentLine.id = `line-${i - 1}`;
                        
                        }
                    }

                    milestoneCounter--;

                }
                else{
                    // Adjust the IDs of subsequent milestones and lines
                    for (let i = milestoneIdNumber + 1; i <= lastMilestoneIdNumber; i++) {
                        // Update milestone ID
                        const currentMilestone = document.getElementById(`milestone-${i}`);
                        if (currentMilestone) {
                            currentMilestone.id = `milestone-${i - 1}`;
                            currentMilestone.textContent = `Milestone ${i - 1}`; // Update content
                        

                          /*  const removeButton = document.createElement('button');
                            removeButton.textContent = 'X';
                            removeButton.style.position = 'absolute';
                            removeButton.style.top = '5px';
                            removeButton.style.right = '5px';
                            removeButton.style.background = 'lightgrey';
                            removeButton.style.color = 'white';
                            removeButton.style.border = 'none';
                            removeButton.style.borderRadius = '50%';
                            removeButton.style.width = '20px';
                            removeButton.style.height = '20px';
                            removeButton.style.cursor = 'pointer';

                            // Center the "X" inside the button
                            removeButton.style.display = 'flex';
                            removeButton.style.justifyContent = 'center';
                            removeButton.style.alignItems = 'center';
                            removeButton.style.padding = '0';
                            removeButton.style.lineHeight = 'normal';
                            removeButton.style.fontSize = '9px';
                            removeButton.onclick = function () {
                                removeMilestone(currentMilestone.id);
                            };
                             

                            currentMilestone.appendChild(removeButton);
                            */
                            
                            
                        }

                        // Update line ID
                        const currentLine = document.getElementById(`line-${i}`);
                        if (currentLine) {
                            currentLine.id = `line-${i - 1}`;
                        
                        }
                    }

                    removeLine(`line-${milestoneIdNumber}`);
                    container.removeChild(milestoneElement);

                    let newnumber = milestoneIdNumber;
                    console.log('newnumber');
                    console.log(newnumber);
                    const nextLine = document.getElementById(`line-${newnumber}`);

                    if(nextLine){
                        console.log('line changing position'+nextLine.id);
                        const elementPosition = getElementPosition(previousMilestoneElement, container);
                        nextLine.setAttribute('x1', elementPosition.x);
                        nextLine.setAttribute('y1', elementPosition.y);
                    }else{
                        console.log('line does not exist');
                    }

                    milestoneCounter--;
                   
                }
            }
        }

        //startLabel
        function removeObstacle(id) {
            const container = document.getElementById('thesis-map-container');
            const obstacleElement = document.getElementById(id);
            const userConfirmed = confirm('Are you sure you want to remove this obstacle?');

            
            const obstacleIdNumber = parseInt(id.split('-')[1], 10);
            const lastObstacleId = lastObstacleElement.id;
            const lastObstacleIdNumber = parseInt(lastObstacleId.split('-')[1], 10);
            console.log('lastObstacleIdNumber');
            console.log(lastObstacleIdNumber);

            if (userConfirmed) {
                console.log(id);
                console.log('Child removed');
                
                container.removeChild(obstacleElement);
                obstacleCounter--;

                for (let i = obstacleIdNumber + 1; i <= lastObstacleIdNumber; i++) {
                    // Update milestone ID
                    const currentObstacle = document.getElementById(`obstacle-${i}`);
                    if (currentObstacle) {
                        currentObstacle.id = `obstacle-${i - 1}`;
                        currentObstacle.textContent = `Obstacle ${i - 1}`; // Update content
                    
                    /*    const removeButton = document.createElement('button');
                        removeButton.textContent = 'X';
                        removeButton.style.position = 'absolute';
                        removeButton.style.top = '5px';
                        removeButton.style.right = '5px';
                        removeButton.style.background = 'lightgrey';
                        removeButton.style.color = 'white';
                        removeButton.style.border = 'none';
                        removeButton.style.borderRadius = '50%';
                        removeButton.style.width = '20px';
                        removeButton.style.height = '20px';
                        removeButton.style.cursor = 'pointer';

                        // Center the "X" inside the button
                        removeButton.style.display = 'flex';
                        removeButton.style.justifyContent = 'center';
                        removeButton.style.alignItems = 'center';
                        removeButton.style.padding = '0';
                        removeButton.style.lineHeight = 'normal';
                        removeButton.style.fontSize = '9px';
                        removeButton.onclick = function () {
                            removeObstacle(currentObstacle.id);
                        };

                        currentObstacle.appendChild(removeButton);
                      */  
                    }

                }
            }
        }

         //startLabel
         function removeFuel(id) {
            const container = document.getElementById('fuelSection');
            const fuelElement = document.getElementById(id);
            const userConfirmed = confirm('Are you sure you want to remove this obstacle?');

            
            const fuelIdNumber = parseInt(id.split('-')[1], 10);
            const lastFuelId = lastFuelElement.id;
            const lastFuelIdNumber = parseInt(lastFuelId.split('-')[1], 10);
            console.log('lastFuelIdNumber');
            console.log(lastFuelIdNumber);

            if (userConfirmed) {
                console.log(id);
                console.log('Child removed');
                
                container.removeChild(fuelElement);
                fuelCounter--;

                for (let i = fuelIdNumber + 1; i <= lastFuelIdNumber; i++) {
                    // Update milestone ID
                    const currentFuel = document.getElementById(`fuel-${i}`);
                    if (currentFuel) {
                        currentFuel.id = `fuel-${i - 1}`;
                        currentFuel.textContent = `Fuel ${i - 1}`; // Update content
                    
                    /*    const removeButton = document.createElement('button');
                        removeButton.textContent = 'X';
                        removeButton.style.position = 'relative';
                        removeButton.style.top = '-20px';
                        removeButton.style.right = '-2px';
                        removeButton.style.background = 'lightgrey';
                        removeButton.style.color = 'black';
                        removeButton.style.border = 'none';
                        removeButton.style.borderRadius = '50%';
                        removeButton.style.width = '15px';
                        removeButton.style.height = '15px';
                        removeButton.style.cursor = 'pointer';

                        // Center the "X" inside the button
                        removeButton.style.display = 'flex';
                        removeButton.style.justifyContent = 'center';
                        removeButton.style.alignItems = 'center';
                        removeButton.style.padding = '0';
                        removeButton.style.lineHeight = 'normal';
                        removeButton.style.fontSize = '9px';
                        removeButton.onclick = function () {
                            removeFuel(currentFuel.id);
                        };

                        currentFuel.appendChild(removeButton);
                      */  
                    }

                }
            }
        }

        // Draw a line between two points
        function drawLine(x1, y1, x2, y2, lineId) {
            const container = document.getElementById('thesis-map-container');
            const svg = document.getElementById('svg-container') || createSvg(container);

            const line = document.createElementNS("http://www.w3.org/2000/svg", "line");
            line.setAttribute("id", lineId); 
            line.setAttribute("x1", x1);
            line.setAttribute("y1", y1);
            line.setAttribute("x2", x2);
            line.setAttribute("y2", y2);
            line.setAttribute("stroke", "black");
            line.setAttribute("stroke-width", "2");
            svg.appendChild(line);
        }

        function removeLine(lineId) {
            const line = document.getElementById(lineId); // Select the line element by its ID
            if (line) {
                line.parentNode.removeChild(line); // Remove the line from its parent (the SVG container)
            } else {
                console.warn(`Line with ID '${lineId}' not found.`);
            }
        }

        // Create the SVG container for lines
        function createSvg(container) {
            const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
            svg.setAttribute("id", "svg-container");
            svg.style.position = 'absolute';
            svg.style.width = '100%';
            svg.style.height = '100%';
            svg.style.top = '0';
            svg.style.left = '0';
            svg.style.pointerEvents = 'none'; // Allow interactions with milestones
            container.insertBefore(svg, container.firstChild);
            return svg;
        }

        // Add movable functionality to elements
        function makeMovable(element) {
            let offsetX = 0;
            let offsetY = 0;

            element.addEventListener("mousedown", (event) => {
                const rect = element.getBoundingClientRect();
                offsetX = event.clientX - rect.left;
                offsetY = event.clientY - rect.top;

                function move(e) {
                    const container = document.getElementById("thesis-map-container");
                    const containerRect = container.getBoundingClientRect();
                    const newX = Math.floor(e.clientX - containerRect.left - offsetX);
                    const newY = Math.floor(e.clientY - containerRect.top - offsetY);

                    element.style.left = `${newX}px`;
                    element.style.top = `${newY}px`;

                    const lineId = `line-${element.id.split('-')[1]}`;  // Example: "line-1"
                    // Extract the numeric part from the lineId and convert it to a number
                    const lineIdNumber = parseInt(lineId.split('-')[1], 10);  // Extract the number after 'line-'
                    const lineId2 = `line-${lineIdNumber + 1}`;  // Increment the number
                    //console.log(lineId2);

                    let nextElementId = `milestone-${lineIdNumber + 1}`;
                    const nextElement = document.getElementById(nextElementId);
                    //console.log(nextElementId);


                    // Update the corresponding line's position
                    const line = document.getElementById(lineId); // Get the line by its ID
                    const line2 = document.getElementById(lineId2);

                    const firstLine = document.getElementById('line-first');
                    const lastLine = document.getElementById('line-last');

                  
                    if(element.id.split('-')[0] === 'milestone'){
                        if (lastMilestoneElement === element) {
                           
                            const lastPosition = getElementPosition(completeLabel, container);
                            const elementPosition = getElementPosition(element, container);
                            lastLine.setAttribute('x1', elementPosition.x);
                            lastLine.setAttribute('y1', elementPosition.y);
                            lastLine.setAttribute("x2", lastPosition.x);
                            lastLine.setAttribute("y2", lastPosition.y);
                            
                        }

                        if (element.id === 'milestone-1') {
                            const elementPosition = getElementPosition(element, container);
                            if(firstLine){
                            
                                firstLine.setAttribute('x2', elementPosition.x);
                                firstLine.setAttribute('y2', elementPosition.y);
                            }
                            if(nextElement && line2){
                                line2.setAttribute('x1', elementPosition.x);
                                line2.setAttribute('y1', elementPosition.y);
                            }
                            
                        }else{
                            const elementPosition = getElementPosition(element, container);
                            if(line){
                                line.setAttribute('x2', elementPosition.x);
                                line.setAttribute('y2', elementPosition.y);
                            }

                            if(line2){
                                line2.setAttribute('x1', elementPosition.x);
                                line2.setAttribute('y1', elementPosition.y);
                            }
                        }
                    }

                    console.log('X');
                    console.log(newX);
                    console.log('Y');
                    console.log(newY);
                    
                   
                }

                function stop() {
                    window.removeEventListener("mousemove", move);
                    window.removeEventListener("mouseup", stop);
                    savemap();
                }

                window.addEventListener("mousemove", move);
                window.addEventListener("mouseup", stop);

                event.preventDefault();
            });
        }

        function addObstacle() {
            const container = document.getElementById('thesis-map-container');
            const newObstacle = document.createElement('div');
            const obstacleName = document.getElementById('obstacle-input').value;
            newObstacle.className = 'draggable obstacle';

            newObstacle.style.lineHeight = '1.2';
            newObstacle.style.padding = '10px';
            newObstacle.style.textAlign = 'center'; // Centers the text horizontally
            newObstacle.style.display = 'flex'; // Allows centering in both directions
            newObstacle.style.alignItems = 'center'; // Vertically centers the text
            newObstacle.style.justifyContent = 'center'; // Horizontally centers the text
       


            const maxWords = 7; // Number of words to show

            function truncateToWords(str, numWords) {
            const words = str.split(' ');
            if (words.length <= numWords) {
                return str;
            }
            return words.slice(0, numWords).join(' ') + '...';
            }

            const truncatedDescription = truncateToWords(obstacleName, maxWords);

            newObstacle.textContent = truncatedDescription; // Add counter
            newObstacle.title = obstacleName; 

            var px = obstacleCounter*10+ 100;
            newObstacle.style.left = `${px}px`;
            newObstacle.style.top = `${px}px`;
            newObstacle.setAttribute("id", `obstacle-${obstacleCounter}`);

                /*const removeButton = document.createElement('button');
                    removeButton.textContent = 'X';
                    removeButton.style.position = 'absolute';
                    removeButton.style.top = '5px';
                    removeButton.style.right = '5px';
                    removeButton.style.background = 'lightgrey';
                    removeButton.style.color = 'black';
                    removeButton.style.border = 'none';
                    removeButton.style.borderRadius = '50%';
                    removeButton.style.width = '20px';
                    removeButton.style.height = '20px';
                    removeButton.style.cursor = 'pointer';

                    // Center the "X" inside the button
                    removeButton.style.display = 'flex';
                    removeButton.style.justifyContent = 'center';
                    removeButton.style.alignItems = 'center';
                    removeButton.style.padding = '0';
                    removeButton.style.lineHeight = 'normal';
                    removeButton.style.fontSize = '9px';
                    removeButton.onclick = function () {
                        removeObstacle(newObstacle.id);
                    };
                    newObstacle.appendChild(removeButton);
                */

           
            container.appendChild(newObstacle);

            lastObstacleElement = newObstacle;

            makeMovable(newObstacle);
            obstacleCounter++;
            document.getElementById('obstacle-input').value = '';
            
            setTimeout(() => {
                $('#refreshDataButton').click();
            }, 1000);

        }

        function addFuel() {

            const fuelSection = document.getElementById("fuelSection");

            if (fuelCounter <= 15) { // Limit fuel count to 5
                const fuel = document.createElement("div");
                const fuelName = document.getElementById('fuel-input').value;
                fuel.className = "fuel";
                fuel.setAttribute("id", `fuel-${fuelCounter}`);
                const maxWords = 3; // Number of words to show

                function truncateToWords(str, numWords) {
                const words = str.split(' ');
                if (words.length <= numWords) {
                    return str;
                }
                return words.slice(0, numWords).join(' ') + '...';
                }

                const truncatedDescription = truncateToWords(fuelName, maxWords);

                fuel.innerHTML = truncatedDescription;

                fuel.title = fuelName;

                fuelSection.appendChild(fuel);
            
                    /*  const removeButton = document.createElement('button');
                        removeButton.textContent = 'X';
                        removeButton.style.position = 'relative';
                        removeButton.style.top = '-20px';
                        removeButton.style.right = '-2px';
                        removeButton.style.background = 'lightgrey';
                        removeButton.style.color = 'black';
                        removeButton.style.border = 'none';
                        removeButton.style.borderRadius = '50%';
                        removeButton.style.width = '15px';
                        removeButton.style.height = '15px';
                        removeButton.style.cursor = 'pointer';

                        // Center the "X" inside the button
                        removeButton.style.display = 'flex';
                        removeButton.style.justifyContent = 'center';
                        removeButton.style.alignItems = 'center';
                        removeButton.style.padding = '0';
                        removeButton.style.lineHeight = 'normal';
                        removeButton.style.fontSize = '9px';
                        removeButton.onclick = function () {
                            removeFuel(fuel.id);
                        };
                        fuel.appendChild(removeButton);
                    */
                lastFuelElement = fuel;
                fuelCounter++;

                document.getElementById('fuel-input').value = '';

            } else {
                alert("Maximum fuel reached!");
            }

          
            setTimeout(() => {
                $('#refreshDataButton').click();
            }, 1000);
        };

        // Apply makeMovable to all draggable elements
        document.querySelectorAll(".draggable").forEach((element) => {
            makeMovable(element);
        });

        // Attach the makeMovable function to all draggable elements
        document.querySelectorAll('.draggable').forEach((element) => {
            makeMovable(element);
        });

    </script>

    @endsection
</x-app-layout>
