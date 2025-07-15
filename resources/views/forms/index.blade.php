<x-app-layout>
    @section('headertitle')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('messages.Forms') }}                          
        </h2>
    @endsection

    @section('style')
    <style>
         #newFormSection {
            width: 100%;
            padding: 5%;
            background-color: #f9fafb;
        }

        #newFormSection label {
            font-size: 18pt;
            color: #4a4a4a;
        }

        .form-control, .form-select {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 0.375rem;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 5px rgba(76, 175, 80, 0.5);
        }

        .btn-question {
            background-color: #34D399;
            color: white;
            padding: 10px 20px;
            border-radius: 0.375rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
            float:right;
           
        }

        .btn-question:hover {
            background-color: #059669;
            transform: translateY(-2px);
        }

        .btn-question:active {
            transform: translateY(0);
        }

        .question-item {
            background-color: #f1f5f9;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .question-item input, .question-item select {
            margin-top: 10px;
        }

        .additional-options {
            padding: 10px;
            margin-top: 10px;
            background-color: #e2e8f0;
            border-radius: 8px;
        }

        .questions-section {
            margin-top: 20px;
        }
        .scalesLabel{
            font-size:14pt !important;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 34px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 14px;
            width: 14px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:checked + .slider:before {
            transform: translateX(14px);
        }

    </style>
   
    @endsection

    @section('maincontent')
      
            <!-- Messages for success and error -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show max-w-7xl mx-auto sm:px-8 mt-2 lg:px-10" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show max-w-7xl mx-auto sm:px-8 mt-2 lg:px-10" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- New tasks -->
        <div class="max-w-12xl mx-auto sm:px-8 mt-2 lg:px-10">
            <div class="container">
                <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="row">
                        <!-- Left Part: Content (col-md-10) -->
                        <div class="col-md-10">
                            <p class="c-grey h4">{{ __('messages.Diaries forms', [], session()->get('applocale'))}}</p>
                        </div>
                        <!-- Right Part: Button (col-md-2) -->
                        <div class="col-md-2 d-flex justify-content-end align-items-start">
                            <!-- Trigger the modal with a button -->
                            <button class="btn btn-primary" onclick="AddNewButton()">{{ __('messages.Add new form', [], session()->get('applocale'))}} +</button>
                        </div>
                    </div>
                    
                   
                </div>
            </div>
        </div>

        <div id="newFormDiv" class="d-none max-w-12xl mx-auto sm:px-8 mt-2 lg:px-10">
            <div class="container">
                <div class="bg-white p-6 overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="row">
                        <!-- Section to add a new form -->
                        
                        <div id="newFormSection" class="mt-4 bg-light p-6 rounded-lg shadow-md">
                            <form id="newForm" method="POST" action="{{ route('forms.create') }}">
                                @csrf

                                <!-- Form Name Section -->
                                <div class="mb-4">
                                    <label for="formName" class="form-label text-xl font-semibold text-gray-700">{{ __('messages.Form Name', [], session()->get('applocale'))}}</label>
                                    <input 
                                        type="text" 
                                        class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                        id="formName" 
                                        name="formName" 
                                        placeholder="Enter form name" 
                                        required
                                    >
                                </div>

                                <div class="mb-4">
                                    <label for="formType" class="form-label text-xl font-semibold text-gray-700">{{ __('messages.Type', [], session()->get('applocale'))}}</label>
                                    <select 
                                        class="form-select mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                        id="formType" 
                                        name="formType" 
                                        required
                                    >
                                        <option value="Initial">{{ __('messages.Initial Form', [], session()->get('applocale'))}}</option>
                                        <option value="Diary">{{ __('messages.Diary Form', [], session()->get('applocale'))}}</option>
                                        <option value="Weekly">{{ __('messages.Weekly Form', [], session()->get('applocale'))}}</option>
                                    </select>
                                </div>

 
                                <!-- Questions Section -->
                                <div class="questions-section mb-4">
                                    <p class="text-2xl font-bold text-gray-800">{{ __('messages.Questions', [], session()->get('applocale'))}}</p>
                                    <div id="sortable-questions">
                                        <!-- Predefined Question Template -->
                                        <div class="question-item mb-4 mt-4 p-4 bg-gray-50 rounded-lg shadow-sm">
                                            <label for="questionText" class="form-label text-lg font-semibold text-gray-700">{{ __('messages.Question 1', [], session()->get('applocale'))}}</label>
                                            <input 
                                                type="text" 
                                                class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                                name="questions[]" 
                                                placeholder="Enter question" 
                                                required
                                            >

                                             <label for="identifier" class="mt-4 form-label text-xl font-semibold text-gray-700">{{ __('messages.Question', [], session()->get('applocale'))}} 1: {{ __('messages.Identifier', [], session()->get('applocale'))}}</label>
                                                <select 
                                                    class="form-select mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                                    id="identifier" 
                                                    name="identifier" 
                                                    required
                                                >
                                                <option value="No">Nan</option>
                                                @foreach($identifiers as $identifier)
                                                    <option value="{{$identifier->name}}">{{$identifier->name}}</option>
                                                @endforeach
                                                </select>


                                             <label for="factor" class="mt-4 form-label text-xl font-semibold text-gray-700">{{ __('messages.Question', [], session()->get('applocale'))}} 1: {{ __('messages.Factor', [], session()->get('applocale'))}}</label>
                                                <select 
                                                    class="form-select mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                                    id="factor" 
                                                    name="factor" 
                                                    required
                                                >
                                                <option value="No">Nan</option>
                                                @foreach($factors as $factor)
                                                    <option value="{{$factor->name}}">{{$factor->name}}</option>
                                                @endforeach
                                                </select>
                                            
                                            <label for="questionType" class="form-label text-lg font-semibold text-gray-700 mt-4">{{ __('messages.Question', [], session()->get('applocale'))}} 1: {{ __('messages.Type', [], session()->get('applocale'))}}</label>
                                            <select 
                                                class="form-select mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                                name="questionTypes[]" 
                                                onchange="toggleAdditionalOptions(this, 1)" 
                                                required
                                            >
                                                <option value="" disabled selected>{{ __('messages.Choose an option', [], session()->get('applocale'))}}</option>
                                                <option value="number">{{ __('messages.Number', [], session()->get('applocale'))}}</option>
                                                <option value="yes_no">{{ __('messages.Yes/No', [], session()->get('applocale'))}}</option>
                                                <option value="text">{{ __('messages.Text', [], session()->get('applocale'))}}</option>
                                                <option value="scale">{{ __('messages.Scale', [], session()->get('applocale'))}}</option>
                                                <option value="large_text">{{ __('messages.Large Text', [], session()->get('applocale'))}}</option>
                                                <option value="checkboxes">{{ __('messages.Checkboxes', [], session()->get('applocale'))}}</option>
                                                <option value="multiple_choice">{{ __('messages.Multiple Option', [], session()->get('applocale'))}}</option>
                                            </select>

                                           



                                            <!-- Additional Options for Scale or Rows -->
                                            <div class="additional-options mt-4 d-none">
                                                <label for="placeholders" class="form-label scalesLabel">{{ __('messages.Question Placeholder', [], session()->get('applocale'))}}</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                                    name="placeholders[]" 
                                                    placeholder="Enter the placeholder of the question" 
                                                    required
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Actions -->
                                <div class="row">
                                    <!-- Add Question Button -->
                                    <div class="col-6 text-left">
                                        <button 
                                            type="button" 
                                            class="btn btn-primary mb-2 px-6 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow-md transition duration-300"
                                            onclick="addAnotherQuestion()"
                                        >
                                            {{ __('messages.Add Question', [], session()->get('applocale'))}} +
                                        </button>
                                    </div>
                                    <!-- Save Form Button -->
                                    <div class="col-6 text-right">
                                        <button 
                                            type="submit" 
                                            class="btn btn-question px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md transition duration-300">
                                            {{ __('messages.Save Form', [], session()->get('applocale'))}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-12xl mx-auto sm:px-8 mt-2 lg:px-10">
            <div class="container">
                <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="row container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('messages.Form name', [], session()->get('applocale'))}}</th>
                                    <th>{{ __('messages.Type', [], session()->get('applocale'))}}</th>
                                    <th>{{ __('messages.Created by', [], session()->get('applocale'))}}</th>
                                    <th>{{ __('messages.Number of users', [], session()->get('applocale'))}}</th>
                                    <th >{{ __('messages.Attach', [], session()->get('applocale'))}}</th>
                                    <th class="text-end">{{ __('messages.Actions', [], session()->get('applocale'))}}</th>
                                    <th>{{ __('messages.Default', [], session()->get('applocale'))}}</th>
                                </tr>
                            </thead>
                            <tbody>
                    @foreach($dforms as $form)
                    <tr>
                        <td>{{ $form->name }}</td>
                        <td>{{ $form->type }}</td>
                      
                        @if($form->is_default == 1)
                        <td>{{ __('messages.Admin', [], session()->get('applocale'))}}</td>
                        <td>{{ __('messages.All', [], session()->get('applocale'))}}</td>
                        <td></td>
                        @else
                        <td>{{ $form->user->name }}</td>
                        <td>{{ count($form->users) }}</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#userModal-{{$form->id}}">
                                <i class="fa fa-user mr-2"></i> {{ __('messages.Attach', [], session()->get('applocale'))}}
                            </a>
                        </td>
                        @endif
                       
                        <td class="text-end">
                            <!-- Edit Button (Link to Edit Page) -->
                            <a href="{{ route('forms.edit', $form->id) }}" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit mr-2"></i>{{ __('messages.Edit', [], session()->get('applocale'))}}
                            </a>

                            <a href="{{ route('forms.duplicate', $form->id) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-copy mr-2"></i>{{ __('messages.Copy', [], session()->get('applocale'))}}
                            </a>

                            <!-- Delete Button (Using a Form to Send DELETE Request) -->
                            @if($form->is_default != 1)
                            <form action="{{ route('forms.destroy', $form->id) }}" method="POST" style="display: inline;" id="deleteForm-{{ $form->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete({{ $form->id }})">
                                    <i class="fa fa-trash mr-2"></i>{{ __('messages.Delete', [], session()->get('applocale'))}}
                                </button>
                            </form>
                            @endif
                        </td>
                        <td>
                            <label class="switch">
                                <input 
                                    type="checkbox" 
                                    id="form-switch-{{ $form->id }}" 
                                    @if($form->is_default) checked disabled @endif
                                    onclick="confirmDefaultChange({{ $form->id }}, this)"
                                >
                                <span class="slider round"></span>
                            </label>
                        </td>

                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="userModal-{{$form->id}}" tabindex="-1" aria-labelledby="userModalLabel-{{$form->id}}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="userModalLabel-{{$form->id}}">{{ __('messages.Select User to Attach the form', [], session()->get('applocale'))}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- Loop through users -->
                                    @foreach($users as $user)
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <span>{{ $user->name }}</span>
                                          
                                            <button class="btn {{ $form->users->contains($user->id) ? 'btn-danger' : 'btn-primary' }} btn-sm" 
                                                    onclick="toggleAttachUser({{ $user->id }}, {{ $form->id }}, this)">
                                                {{ $form->users->contains($user->id) ? 'Detach' : 'Attach' }}
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="refreshPage()">{{ __('messages.Close', [], session()->get('applocale'))}}</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
                </tbody>
                        </table>
                    </div>
                </div>
                 {{ $dforms->links() }}
            </div>
        </div>

    @endsection

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        function confirmDefaultChange(formId, checkbox) {
            if (confirm("Are you sure you want to make this form the default?")) {
                // Call the backend via AJAX or form submission
                fetch(`/forms/${formId}/make-default`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => {
                    if (response.ok) {
                        alert("Form set as default successfully!");
                        window.location.reload(); // Reload to update the UI
                    } else {
                        alert("Failed to set form as default.");
                        checkbox.checked = false; // Revert checkbox if action fails
                    }
                })
                .catch(error => {
                    alert("An error occurred: " + error.message);
                    checkbox.checked = false; // Revert checkbox if action fails
                });
            } else {
                // Revert the checkbox state if the user cancels
                checkbox.checked = !checkbox.checked;
            }
        }

    </script>
    <script>
        function refreshPage() {
            location.reload();
        }
    </script>
    <script>
        function confirmDelete(formId) {
            // Display a confirmation dialog
            const confirmation = confirm('Are you sure you want to delete this form?');
            
            // If the user confirms, submit the form
            if (confirmation) {
                document.getElementById('deleteForm-' + formId).submit();
            }
        }

        function toggleAttachUser(userId, formId, button) {
            // Send AJAX request to attach or detach user
            fetch(`/forms/${formId}/attach-user/${userId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ user_id: userId, form_id: formId })
            })
            .then(response => response.json())
            .then(data => {
                // Update button state based on response
                if (data.attached) {
                    button.classList.remove('btn-primary');
                    button.classList.add('btn-danger');
                    button.innerText = 'Detach';
                } else {
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-primary');
                    button.innerText = 'Attach';
                }
                alert(data.message);
            })
            .catch(error => console.error('Error:', error));
        }

    </script>
    <script>

         // Initialize SortableJS
         new Sortable(document.getElementById('sortable-questions'), {
            animation: 150,
            handle: '.question-item', // Drag handle (the entire question-item)
            onEnd: function (evt) {
                // You can add custom logic here, like updating the order in a hidden input
                console.log('New order:', evt.to);
            }
        });

        countQuestions = 1;
        function addAnotherQuestion() {
            const questionsSection = document.getElementById('sortable-questions');
            const newQuestion = document.createElement('div');
            const factors = @json($factors);
            const identifiers = @json($identifiers);
            newQuestion.classList.add('question-item', 'mb-3');
            let factorOptions = `<option value="No">Nan</option>`;
            factors.forEach(factor => {
                factorOptions += `<option value="${factor.name}">${factor.name}</option>`;
            });


            let identifierOptions = `<option value="No">Nan</option>`;
            identifiers.forEach(identifier => {
                identifierOptions += `<option value="${identifier.name}">${identifier.name}</option>`;
            });

            newQuestion.innerHTML = `
                <label for="questionText" class="form-label text-lg font-semibold text-gray-700">{{ __('messages.Question', [], session()->get('applocale'))}} ${countQuestions+1}</label>
                <input 
                    type="text" 
                    class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                    name="questions[]" 
                    placeholder="Enter question" 
                    required
                >

                 <label class="form-label text-lg font-semibold text-gray-700 mt-4">{{ __('messages.Question', [], session()->get('applocale'))}} ${countQuestions+1}: {{ __('messages.Identifier', [], session()->get('applocale'))}}</label>
                <select class="form-select mt-2 p-3 border border-gray-300 rounded-lg w-full" name="identifier[]" required>
                    ${identifierOptions}
                </select>



                 <label class="form-label text-lg font-semibold text-gray-700 mt-4">{{ __('messages.Question', [], session()->get('applocale'))}} ${countQuestions+1}: {{ __('messages.Factor', [], session()->get('applocale'))}}</label>
                <select class="form-select mt-2 p-3 border border-gray-300 rounded-lg w-full" name="factor[]" required>
                    ${factorOptions}
                </select>

                <label for="questionType" class="form-label text-lg font-semibold text-gray-700 mt-4"> {{ __('messages.Question', [], session()->get('applocale'))}} ${countQuestions+1}: {{ __('messages.Type', [], session()->get('applocale'))}}</label>
                <select 
                    class="form-select mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                    name="questionTypes[]" 
                    onchange="toggleAdditionalOptions(this, ${countQuestions+1})" 
                    required
                >
                    <option value="" disabled selected>Choose an option</option>
                    <option value="number">Number</option>
                    <option value="yes_no">Yes/No</option>
                    <option value="text">Text</option>
                    <option value="scale">Scale</option>
                    <option value="large_text">Large Text</option>
                    <option value="checkboxes">Checkboxes</option>
                    <option value="multiple_choice">Multiple Option</option>
                </select>

               
                <!-- Additional Options for Scale or Rows -->
                <div class="additional-options mt-4 d-none"></div>
                 <!-- Remove Button -->
                <div style="display: flex; justify-content: flex-start;" dir="rtl">
                    <button type="button" style="float:right" class="btn btn-danger mt-4 mb-2 remove-question" onclick="removeQuestion(this)">Remove Question  ${countQuestions + 1} </button>
                </div>
            `;
            questionsSection.appendChild(newQuestion);
            countQuestions++;
        }

        function removeQuestion(button) {
            // Remove the question item (parent of the button)
            button.closest('.question-item').remove();
            countQuestions--;
        }

        function AddNewButton() {
            var formsection = document.getElementById('newFormDiv');
            formsection.classList.remove('d-none');  // Correct method to remove a class
        }

        function toggleAdditionalOptions(select, countQuestions) {
            const additionalOptions = select.closest('.question-item').querySelector('.additional-options');
            additionalOptions.innerHTML = ''; // Clear previous options

            if (select.value === 'scale') {
                additionalOptions.innerHTML = `
                    <label for="scaleNumber" class="form-label scalesLabel">Number of Scales</label>
                    <input type="number" class="form-control" name="scales[]" placeholder="Enter number of scales">
                    <label for="scaleMin" class="form-label scalesLabel mt-4">Min description</label>
                    <input type="text" class="form-control" name="scalemins[]" placeholder="Enter a short description of the minimum scale">
                    <label for="scaleMax" class="form-label scalesLabel mt-4">Max description</label>
                    <input type="text" class="form-control" name="scalemaxs[]" placeholder="Enter a short description of the maximum scale">
                `;
                additionalOptions.classList.remove('d-none');
            } else if (select.value === 'large_text') {
                additionalOptions.innerHTML = `
                    <label for="placeholders" class="form-label scalesLabel">Question Placeholder</label>
                    <input 
                        type="text" 
                        class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                        name="placeholders[]" 
                        placeholder="Enter the placeholder of the question" 
                        required
                    >
                    <label for="rowsNumber" class="form-label mt-4 scalesLabel">Number of Rows</label>
                    <input type="number" class="form-control" name="rows[]" placeholder="Enter number of rows">
                `;
                additionalOptions.classList.remove('d-none');
            } else if (select.value === 'text' || select.value === 'number') {
                additionalOptions.innerHTML = `
                    <label for="placeholders" class="form-label scalesLabel">Question Placeholder</label>
                    <input 
                        type="text" 
                        class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                        name="placeholders[]" 
                        placeholder="Enter the placeholder of the question" 
                        required
                    >
                `;
                additionalOptions.classList.remove('d-none');
            } else if (select.value === 'multiple_choice' || select.value === 'checkboxes') {
                const inputType = select.value === 'multiple_choice' ? 'radio' : 'checkbox';
                additionalOptions.innerHTML = `
                    <div class="${inputType}-container">
                        <label for="${inputType}" class="form-label scalesLabel">${inputType === 'radio' ? 'Multiple Choice' : 'Checkbox'} Options</label>
                        <div class="option-item d-flex align-items-center">
                            <input 
                                type="${inputType}" 
                                disabled 
                                class="form-check-input me-2 ml-4"
                            >
                            <input 
                                type="text" 
                                style="width:70%; margin-left:50px"
                                class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                name="${inputType}[${countQuestions}][]" 
                                placeholder="Enter an option" 
                                required
                            >
                            <button type="button" class="btn btn-danger ms-2 remove-option">Remove -</button>
                        
                        </div>
                         <button  type="button" class="btn btn-primary mt-4 ml-4 add-option">Add option +</button>
                    </div>
                `;
                setTimeout(() => addDynamicOptionHandlers(additionalOptions, inputType, countQuestions), 0); // Delay to ensure DOM exists
                additionalOptions.classList.remove('d-none');
            } else {
                additionalOptions.classList.add('d-none');
            }
        }

        function addDynamicOptionHandlers(container, inputType, countQuestions) {
            const addOptionButton = container.querySelector('.add-option');

            if (addOptionButton) {
                addOptionButton.addEventListener('click', () => {
                    const newOption = document.createElement('div');
                    newOption.classList.add('option-item', 'd-flex', 'align-items-center');
                    newOption.innerHTML = `
                        <input 
                            type="${inputType}" 
                            disabled 
                            class="form-check-input me-2 ml-4"
                        >
                        <input 
                            type="text" 
                            style="width:70%; margin-left:50px"
                            class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                            name="${inputType}[${countQuestions}][]" 
                            placeholder="Enter an option" 
                            required
                        >
                        <button type="button" class="btn btn-danger ms-2 remove-option">Remove -</button>
                    `;
                    container.querySelector(`.${inputType}-container`).insertBefore(newOption, addOptionButton);

                    // Attach remove handler for the new option
                    addRemoveOptionHandler(newOption.querySelector('.remove-option'));
                });
            }

            // Attach event listeners for Remove buttons
            container.querySelectorAll('.remove-option').forEach(removeButton => {
                addRemoveOptionHandler(removeButton);
            });
        }

        function addRemoveOptionHandler(button) {
            button.addEventListener('click', () => {
                button.closest('.option-item').remove();
            });
        }

    </script>

  
    @endsection
</x-app-layout>
