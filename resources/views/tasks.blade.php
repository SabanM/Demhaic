<x-app-layout>
    @section('headertitle')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
           
              {{ __('messages.Tasks', [], session()->get('applocale'))}}                 
        </h2>
    @endsection

    @section('maincontent')
      
        <!-- New tasks -->
        <div class="max-w-7xl mx-auto sm:px-8 mt-2 lg:px-10">
            <div class="container">
                <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="row">
                        <!-- Left Part: Content (col-md-10) -->
                        <div class="col-md-10">
                            <p class="c-grey h4">{{ __('messages.My tasks list', [], session()->get('applocale'))}}</p>
                        </div>
                        <!-- Right Part: Button (col-md-2) -->
                        <div class="col-md-2 d-flex justify-content-end align-items-start">
                            <!-- Trigger the modal with a button -->
                            <button class="btn btn-primary" data-toggle="modal" data-target="#taskModal">{{ __('messages.Add new', [], session()->get('applocale'))}} +</button>
                        </div>
                    </div>
                    
                    <div class="row mt-2">
                       
                        <div class="table-responsive">
                        <table class="table table-hover m-4">
                            <thead>
                                <tr>
                                    <th style="width:30%" class="no-wrap">{{ __('messages.Task', [], session()->get('applocale'))}}</th>
                                    <th class="text-nowrap">{{ __('messages.Created at', [], session()->get('applocale'))}}</th>
                                    <th class="text-nowrap">{{ __('messages.Deadline', [], session()->get('applocale'))}}</th>
                                    <th class="text-nowrap">{{ __('messages.Actions', [], session()->get('applocale'))}}</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks->sortBy('deadline')  as $task)
                                    @if(!$task->completed)
                                    <tr>
                                        <td class="text-nowrap" style="width:30%" class="no-wrap">{{ $task->title }}</td>
                                        <td class="text-nowrap" >{{ \Carbon\Carbon::parse($task->created_at)->format('d/m/Y') }}</td>
                                        <td class="text-nowrap"
                                            style="color: {{ \Carbon\Carbon::parse($task->deadline)->isToday() || \Carbon\Carbon::parse($task->deadline)->isPast() || \Carbon\Carbon::parse($task->deadline)->isTomorrow() ? 'red' : 'inherit' }}">
                                            {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}
                                        </td>
                                        <td class=" d-flex text-nowrap justify-content-start align-items-center">
                                            <form action="{{ route('tasks.complete', $task->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm  bg-green"> <i class="fa fa-check mr-2"></i> {{ __('messages.Done', [], session()->get('applocale'))}}</button>
                                            </form>
                                            <button class="btn btn-sm  btn-warning mx-1" 
                                                onclick="openEditTaskModal({{ $task->id }}, @js($task->title), @js($task->deadline))">
                                                <i class="fa fa-edit mr-2"></i>
                                                {{ __('messages.Edit', [], session()->get('applocale'))}}
                                              
                                            </button>
                               
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE') <!-- Method spoofing -->
                                                <button type="submit" class="btn btn-sm  bg-red" onclick="return confirm('Are you sure you want to delete this task?')"><i class="fa fa-trash mr-2"></i>{{ __('messages.Delete', [], session()->get('applocale'))}} </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Task Edit Structure -->
        <div class="modal fade mt-4" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="editTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title h4" id="editTaskModalLabel">{{ __('messages.Edit Task', [], session()->get('applocale'))}}</h3>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="edit-task-form" method="POST" action="{{ route('tasks.edit') }}">
                    @csrf <!-- CSRF token for security -->
                    <div class="modal-body">
                     
                        <div class="form-group">
                            <label for="edit-task-input">{{ __('messages.Description', [], session()->get('applocale'))}}</label>
                            <textarea type="text" rows="5" class="form-control" id="edit-task-input" name="title" placeholder="Edit your task" required></textarea>
                        </div>
                 
                        <input type="hidden" id="edit-task-id" name="task_id">

                        <label for="edit-task-deadline" id="edit-task-deadline-label">{{ __('messages.Deadline date', [], session()->get('applocale'))}}</label>
                        <input type="datetime-local" id="edit-task-deadline" name="deadline">
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.Cancel', [], session()->get('applocale'))}}</button>
                        <button type="submit" class="btn btn-success" id="update-task-btn">{{ __('messages.Update Task', [], session()->get('applocale'))}}</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Old tasks -->
        <div class="max-w-7xl mx-auto sm:px-8 mt-4 lg:px-10">
            <div class="container">
                <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="row">
                        <!-- Left Part: Content (col-md-10) -->
                        <div class="col-md-10">
                            <p class="c-grey h4">{{ __('messages.Completed tasks', [], session()->get('applocale'))}}</p>
                        </div>
                        <!-- Right Part: Button (col-md-2) -->
                    </div>
                    <div class="row mt-4">
                        
                          <div class="table-responsive">
                        <table class="table table-hover m-4">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">{{ __('messages.Task', [], session()->get('applocale'))}}</th>
                                    <th class="text-nowrap">{{ __('messages.Finished at', [], session()->get('applocale'))}}</th>
                                    <th class="text-nowrap">{{ __('messages.Delete', [], session()->get('applocale'))}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
                                    @if($task->completed)
                                    <tr>
                                        <td class="text-nowrap">{{ $task->title }}</td>
                                        <td class="text-nowrap">{{ \Carbon\Carbon::parse($task->updated_at)->format('d/m/Y')  }}</td>
                                        <td class="text-nowrap">
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE') <!-- Method spoofing -->
                                                <button type="submit" class="btn btn-sm bg-red" onclick="return confirm('Are you sure you want to delete this task?')"><i class="fa fa-trash mr-2"></i>{{ __('messages.Delete', [], session()->get('applocale'))}}</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                  
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade mt-4" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="taskModalLabel">{{ __('messages.Add a new Task', [], session()->get('applocale'))}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('tasks.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <!-- Task Title Input -->
                            <div class="form-group">
                                <label for="task-title">{{ __('messages.Task', [], session()->get('applocale'))}}</label>
                                <input type="text" name="title" id="task-title" class="form-control" placeholder="Enter task title" required>
                            </div>

                            <!-- Deadline Input -->
                            <div class="form-group">
                                <label for="task-deadline">{{ __('messages.Deadline', [], session()->get('applocale'))}}</label>
                                <input type="date" name="deadline" id="task-deadline" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.Close', [], session()->get('applocale'))}}</button>
                            <button type="submit" class="btn btn-primary">{{ __('messages.Add Task', [], session()->get('applocale'))}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
    <script>
        function openEditTaskModal(taskId, description, deadline) {
            // Populate the modal fields with existing task data
            document.getElementById('edit-task-id').value = taskId;
            document.getElementById('edit-task-input').value = description;
            document.getElementById('edit-task-deadline').value = deadline;
           
            // Show the modal
            $('#editTaskModal').modal('show');
        }
    </script>
    @endsection
</x-app-layout>
