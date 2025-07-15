<x-app-layout>
    @section('headertitle')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          
              {{ __('messages.Milestones', [], session()->get('applocale'))}}                                             
        </h2>
    @endsection

    @section('maincontent')
      
        <!-- New tasks -->
        <div class="max-w-7xl mx-auto sm:px-8 mt-2 lg:px-10">
            <div class="container">
                <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="row ">
                        <!-- Left Part: Content (col-md-10) -->
                        <div class="col-md-7">
                            <p class="c-grey h4">{{ __('messages.My list of milestones', [], session()->get('applocale'))}}</p>
                        </div>
                        <!-- Right Part: Button (col-md-2) -->
                        <div class="col-md-3 mt-4 col-8 d-flex justify-content-end align-items-start">
                            <!-- Trigger the modal with a button -->
                            <a href="{{ route('thesismap') }}" class="btn bg-green"><i class="fa fa-cog mr-2"></i>{{ __('messages.Manage the thesis map', [], session()->get('applocale'))}}</a>
                        </div>
                        <div class="col-md-2 mt-4 col-4 d-flex justify-content-end align-items-start">
                            <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#milestoneModal">{{ __('messages.Add new', [], session()->get('applocale'))}} +</button>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="table-responsive">
                        <table id="sortable-table-milestones" class="table table-hover m-4">
                            <thead>
                                <tr>
                                   
                                    <th class="text-nowrap">{{ __('messages.Order', [], session()->get('applocale'))}}</th>
                                    <th class="text-nowrap">{{ __('messages.Milestone', [], session()->get('applocale'))}}</th>
                                    <th class="text-nowrap">{{ __('messages.Created at', [], session()->get('applocale'))}}</th>
                                    <th class="text-nowrap">{{ __('messages.Finished at', [], session()->get('applocale'))}}</th>
                                    <th class="text-nowrap">{{ __('messages.Actions', [], session()->get('applocale'))}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($milestones->sortBy('name') as $milestone)
                                    <tr data-id="{{ $milestone->id }}">
                                
                                        @php
                                            $parts = explode('-', $milestone->name);
                                            $number = end($parts);
                                        @endphp
                                      
                                        <td class="text-nowrap"><i class="fa fa-arrows mr-4"></i>{{ $loop->index + 1  }}</td>
                                        <td class="text-nowrap">{{ $milestone->milestone }}</td>
                                        <td class="text-nowrap">{{ \Carbon\Carbon::parse($milestone->created_at)->format('d/m/Y H:i') }}</td>
                                        @if($milestone->finished_at)
                                            <td class="text-nowrap">{{ \Carbon\Carbon::parse($milestone->finished_at)->format('d/m/Y H:i') }}</td>
                                        @else
                                            <td class="text-nowrap">{{ __('messages.In progress', [], session()->get('applocale'))}} ...</td>
                                        @endif
                                        <td class="text-nowrap d-flex justify-content-start align-items-center">
                                            <button style="width:30%" class="btn btn-sm mx-1 @if($milestone->finished_at) disabled btn-secondary @else btn-success @endif" onclick="finishMilestone({{ $milestone->id }})" >
                                            @if($milestone->finished_at)
                                            {{ __('messages.Finished', [], session()->get('applocale'))}}
                                            @else
                                            <i class="fa fa-flag-checkered mr-2"></i>{{ __('messages.Finish', [], session()->get('applocale'))}}
                                            @endif
                                            </button>

                                            <button class="btn btn-sm btn-warning mx-1" 
                                                    onclick="openEditMilestoneModal({{ $milestone->id }}, @js($milestone->milestone), @js($milestone->finished_at))">

                                                <i class="fa fa-edit mr-2"></i>{{ __('messages.Edit', [], session()->get('applocale'))}}
                                            </button>

                                            <form action="{{ route('milestones.remove', $milestone->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this milestone?');">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm mx-1"><i class="fa fa-trash mr-2"></i>{{ __('messages.Delete', [], session()->get('applocale'))}}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
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
                                <textarea type="text" rows="5" class="form-control" id="milestone-input" name="milestone" placeholder="Enter your milestone" required></textarea>
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

                <!-- Modal Milestone Edit Structure -->
                <div class="modal fade mt-4" id="editMilestoneModal" tabindex="-1" role="dialog" aria-labelledby="editMilestoneModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title h4" id="editMilestoneModalLabel">{{ __('messages.Edit Milestone', [], session()->get('applocale'))}}</h3>
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

     

       
    @endsection

    @section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>

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

        function openEditMilestoneModal(milestoneId, description, finishDate) {
            // Populate the modal fields with existing milestone data
            document.getElementById('edit-milestone-id').value = milestoneId;
            document.getElementById('edit-milestone-input').value = description;
            if(finishDate){
                let finish= new Date(finishDate); // Current date
                let formattedDate =  finish.toISOString().slice(0, 16);
                document.getElementById('edit-milestone-finish').style.display = 'block';
                document.getElementById('edit-milestone-finish-label').style.display = 'block';
                document.getElementById('edit-milestone-finish').value = formattedDate;

            }else{
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
    </script>
    @endsection
</x-app-layout>
