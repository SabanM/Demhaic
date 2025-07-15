<x-app-layout>
    @section('headertitle')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Forms') }}                          
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
        <div class="max-w-7xl mx-auto sm:px-8 mt-2 lg:px-10">
            <div class="container">
                <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="row">
                        <!-- Left Part: Content (col-md-10) -->
                        <div class="col-md-10">
                            <p class="c-grey h4">{{ __('messages.Edit the form', [], session()->get('applocale'))}}: {{ $form->name }}</p>
                        </div>
                        <!-- Right Part: Button (col-md-2) 
                        <div class="col-md-2 d-flex justify-content-end align-items-start">
                            -- Trigger the modal with a button --
                            <button class="btn btn-primary" onclick="AddNewButton()">Add new form +</button>
                        </div>
                        -->
                    </div>
                    
                   
                </div>
            </div>
        </div>

        <div id="newFormDiv" class="max-w-7xl mx-auto sm:px-8 mt-2 lg:px-10">
            <div class="container">
                <div class="bg-white p-6 overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="row">
                        <!-- Section to add a new form -->
                        
                        <div id="newFormSection" class="mt-4 bg-light p-6 rounded-lg shadow-md">
                        <form id="newForm" method="POST" action="{{ route('forms.update', ['form' => $form->id ]) }}">
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
                                        value="{{ $form->name }}"
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
                                        <option value="Initial" {{ $form->type == 'Initial' ? 'selected' : '' }}>{{ __('messages.Initial Form', [], session()->get('applocale'))}}</option>    
                                        <option value="Diary" {{ $form->type == 'Diary' ? 'selected' : '' }}>{{ __('messages.Diary Form', [], session()->get('applocale'))}}</option>
                                        <option value="Weekly" {{ $form->type == 'Weekly' ? 'selected' : '' }}>{{ __('messages.Weekly Form', [], session()->get('applocale'))}}</option>
                                    </select>
                                </div>

                              
                                <!-- Questions Section -->
                                <div class="questions-section mb-4">
                                    <p class="text-2xl font-bold text-gray-800">Questions</p>
                                    <div id="sortable-questions">
                                        <!-- Predefined Question Template -->
                                        @foreach($form->questions as $index => $q)
                                        @php  $question_number =  $loop->iteration @endphp
                                        <div class="question-item mb-4 mt-4 p-4 bg-gray-50 rounded-lg shadow-sm">
                                            <label for="questionText" class="form-label text-lg font-semibold text-gray-700">{{ __('messages.Question', [], session()->get('applocale'))}} {{ $question_number }}</label>
                                            <input 
                                                type="text" 
                                                class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                                name="questions[]" 
                                                placeholder="Enter question" 
                                                required
                                                value="{{ $q->question}}"
                                            >
                                            
                                            <label for="questionType" class="form-label text-lg font-semibold text-gray-700 mt-4">{{ __('messages.Question', [], session()->get('applocale'))}} {{ $question_number }} Type</label>
                                            <select 
                                                class="form-select mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                                name="questionTypes[]" 
                                                onchange="toggleAdditionalOptions(this, {{ $question_number }})" 
                                                required
                                            >
                                                <option value="" disabled {{ $q->type == null ? 'selected' : '' }}>{{ __('messages.Choose an option', [], session()->get('applocale'))}}</option>
                                                <option value="number" {{ $q->type == 'number' ? 'selected' : '' }}>{{ __('messages.Number', [], session()->get('applocale'))}}</option>
                                                <option value="yes_no" {{ $q->type == 'yes_no' ? 'selected' : '' }}>{{ __('messages.Yes/No', [], session()->get('applocale'))}}</option>
                                                <option value="text" {{ $q->type == 'text' ? 'selected' : '' }}>{{ __('messages.Text', [], session()->get('applocale'))}}</option>
                                                <option value="scale" {{ $q->type == 'scale' ? 'selected' : '' }}>{{ __('messages.Scale', [], session()->get('applocale'))}}</option>
                                                <option value="large_text" {{ $q->type == 'large_text' ? 'selected' : '' }}>{{ __('messages.Large Text', [], session()->get('applocale'))}}</option>
                                                <option value="checkboxes" {{ $q->type == 'checkboxes' ? 'selected' : '' }}>{{ __('messages.Checkboxes', [], session()->get('applocale'))}}</option>
                                                <option value="multiple_choice" {{ $q->type == 'multiple_choice' ? 'selected' : '' }}>{{ __('messages.Multiple Option', [], session()->get('applocale'))}}</option>
                                            </select>

                                            <!-- Additional Options for Scale or Rows -->
                                        
                                            <div id="additional-options-{{ $question_number }}" class="additional-options mt-4">
                                                @if($q->placeholder)
                                                    <label for="placeholders" class="form-label scalesLabel">{{ __('messages.Question Placeholder', [], session()->get('applocale'))}}</label>
                                                    <input 
                                                        type="text" 
                                                        class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                                        name="placeholders[]" 
                                                        placeholder="Enter the placeholder of the question" 
                                                        required
                                                        value="{{ $q->placeholder }}"
                                                    >
                                                @endif
                                                @if($q->type == 'large_text')
                                                
                                                    <label for="rowsNumber" class="form-label mt-4 scalesLabel">{{ __('messages.Number of Rows', [], session()->get('applocale'))}}</label>
                                                    <input type="number" class="form-control" name="rows[]" placeholder="Enter number of rows" value="{{$q->rows}}">
                                                @endif

                                                @if($q->type == 'scale')
                                                
                                                <label for="scaleNumber" class="form-label scalesLabel">{{ __('messages.Number of Scales', [], session()->get('applocale'))}}</label>
                                                <input type="number" class="form-control" name="scales[]" value="{{ $q->scale}}"  placeholder="Enter number of scales">
                                                <label for="scaleMin" class="form-label scalesLabel mt-4">{{ __('messages.Min description', [], session()->get('applocale'))}}</label>
                                                <input type="text" class="form-control" name="scalemins[]" value="{{ $q->scalemin}}" placeholder="Enter a short description of the minimum scale">
                                                <label for="scaleMax" class="form-label scalesLabel mt-4">{{ __('messages.Max description', [], session()->get('applocale'))}}</label>
                                                <input type="text" class="form-control" name="scalemaxs[]" value="{{ $q->scalemax}}"  placeholder="Enter a short description of the maximum scale">
                                            @endif

                                            @if($q->type == 'checkboxes')
                                            <div class="checkbox-container">
                                                    <label for="checkbox" class="form-label scalesLabel">{{ __('messages.Checkbox Options', [], session()->get('applocale'))}}</label>
                                                    @foreach($q->options as $c)
                                                    <div class="option-item d-flex align-items-center">
                                                        
                                                        <input 
                                                            type="checkbox" 
                                                            disabled 
                                                            class="form-check-input me-2 ml-4"
                                                        >
                                                        <input 
                                                            type="text" 
                                                            style="width:70%; margin-left:50px"
                                                            class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                                            name="checkbox[{{ $question_number }}][]" 
                                                            placeholder="Enter an option" 
                                                            value="{{$c}}"
                                                            required
                                                        >
                                                        <button type="button" class="btn btn-danger ms-2 remove-option">{{ __('messages.Remove', [], session()->get('applocale'))}} -</button>
                                                    
                                                    </div>
                                                    @endforeach
                                                    <button  type="button" class="btn btn-primary mt-4 ml-4 add-option">{{ __('messages.Add option', [], session()->get('applocale'))}} +</button>
                                                </div>
                                            @endif

                                            @if($q->type == 'multiple_choice')
                                            <div class="radio-container">
                                                    <label for="radio" class="form-label scalesLabel">{{ __('messages.Multiple Options', [], session()->get('applocale'))}}</label>
                                                    @foreach($q->options as $m)
                                                    <div class="option-item d-flex align-items-center">
                                                        
                                                        <input 
                                                            type="radio" 
                                                            disabled 
                                                            class="form-check-input me-2 ml-4"
                                                        >
                                                        <input 
                                                            type="text" 
                                                            style="width:70%; margin-left:50px"
                                                            class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                                            name="radio[{{ $question_number }}][]" 
                                                            placeholder="Enter an option" 
                                                            value="{{$m}}"
                                                            required
                                                        >
                                                        <button type="button" class="btn btn-danger ms-2 remove-option">{{ __('messages.Remove', [], session()->get('applocale'))}} -</button>
                                                    
                                                    </div>
                                                    @endforeach
                                                    <button  type="button" class="btn btn-primary mt-4 ml-4 add-option">{{ __('messages.Add option', [], session()->get('applocale'))}} +</button>
                                                </div>
                                            @endif

                                            </div>
                                            @if($question_number > 1)
                                                <!-- Remove Button -->
                                                <div style="display: flex; justify-content: flex-start;" dir="rtl">
                                                    <button type="button" style="float:right" class="btn btn-danger mt-4 mb-2 remove-question" onclick="removeQuestion(this)">{{ __('messages.Remove Question', [], session()->get('applocale'))}} {{$question_number}} </button>
                                                </div>
                                            @endif
                                        </div>
                                        @endforeach
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
                                            {{ __('messages.Update Form', [], session()->get('applocale'))}}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    
    @endsection

    @section('scripts')
   
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Attach event listeners to all existing remove-option buttons on page load
            document.querySelectorAll('.remove-option').forEach(removeButton => {
                addRemoveOptionHandler(removeButton);
            });

            document.querySelectorAll('.add-option').forEach(addButton => {
                const container = addButton.closest('.additional-options'); // Find the relevant container using its id
                const containerId = container.id; // e.g., "additional-options-1"
                const countQuestions = containerId.match(/\d+/)[0]; // Extract the iteration number (e.g., '1')
                const innerContainer = container.querySelector('.checkbox-container, .radio-container');

                if (innerContainer) {
                    if (innerContainer.classList.contains('radio-container')) {
                        inputType = 'radio';
                    } else if (innerContainer.classList.contains('checkbox-container')) {
                        inputType = 'checkbox';
                    }
                } else {
                    console.error("No valid inner container found within:", container);
                    return; // Exit the function if no valid inner container is found
                }
                
                addDynamicOptionHandlers(container, inputType, countQuestions);
                
            });
        });

        function addRemoveOptionHandler(button) {
            button.addEventListener('click', () => {
                button.closest('.option-item').remove();
            });
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

        var countQuestions = Number(<?php echo count($form->questions);?>);

        function addAnotherQuestion() {
            const questionsSection = document.getElementById('sortable-questions');
            const newQuestion = document.createElement('div');
            newQuestion.classList.add('question-item', 'mb-3');
            newQuestion.innerHTML = `
                <label for="questionText" class="form-label text-lg font-semibold text-gray-700">Question ${countQuestions + 1}</label>
                <input 
                    type="text" 
                    class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                    name="questions[]" 
                    placeholder="Enter question" 
                    required
                >

                <label for="questionType" class="form-label text-lg font-semibold text-gray-700 mt-4">Question Type</label>
                <select 
                    class="form-select mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                    name="questionTypes[]" 
                    onchange="toggleAdditionalOptions(this)" 
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
                <div id="additional-options-${countQuestions + 1}"  class="additional-options mt-4 d-none"></div>
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
                setTimeout(() => addDynamicOptionHandlers(additionalOptions, inputType), 0); // Delay to ensure DOM exists
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
