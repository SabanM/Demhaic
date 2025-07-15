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
            float: right;
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
        .scalesLabel {
            font-size: 14pt !important;
        }
    </style>
    @endsection

    @section('maincontent')
        <!-- Success and error messages -->
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

        <!-- Form editing section -->
        <div class="max-w-7xl mx-auto sm:px-8 mt-2 lg:px-10">
            <div class="container">
                <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="row">
                        <div class="col-md-10">
                            <p class="c-grey h4">
                                {{ __('messages.Edit the form', [], session()->get('applocale')) }}: {{ $form->name }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="newFormDiv" class="max-w-7xl mx-auto sm:px-8 mt-2 lg:px-10">
            <div class="container">
                <div class="bg-white p-6 overflow-hidden shadow-lg sm:rounded-lg">
                    <div class="row">
                        <!-- New Form Section -->
                        <div id="newFormSection" class="mt-4 bg-light p-6 rounded-lg shadow-md">
                            <form id="newForm" method="POST" action="{{ route('forms.update', ['form' => $form->id ]) }}">
                                @csrf

                                <!-- Form Name -->
                                <div class="mb-4">
                                    <label for="formName" class="form-label text-xl font-semibold text-gray-700">
                                        {{ __('messages.Form Name', [], session()->get('applocale')) }}
                                    </label>
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

                               

                                <!-- Form Type -->
                                <div class="mb-4">
                                    <label for="formType" class="form-label text-xl font-semibold text-gray-700">
                                        {{ __('messages.Type', [], session()->get('applocale')) }}
                                    </label>
                                    <select 
                                        class="form-select mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                        id="formType" 
                                        name="formType" 
                                        required
                                    >
                                        <option value="Initial" {{ $form->type == 'Initial' ? 'selected' : '' }}>
                                            {{ __('messages.Initial Form', [], session()->get('applocale')) }}
                                        </option>    
                                        <option value="Diary" {{ $form->type == 'Diary' ? 'selected' : '' }}>
                                            {{ __('messages.Diary Form', [], session()->get('applocale')) }}
                                        </option>
                                        <option value="Weekly" {{ $form->type == 'Weekly' ? 'selected' : '' }}>
                                            {{ __('messages.Weekly Form', [], session()->get('applocale')) }}
                                        </option>
                                    </select>
                                </div>
                               


                                <!-- Questions Section -->
                                <div class="questions-section mb-4">
                                    <p class="text-2xl font-bold text-gray-800">Questions</p>
                                    <div id="sortable-questions">
                                        <!-- Predefined questions -->
                                        @foreach($form->questions as $index => $q)
                                            @php
                                                $question_number = $loop->iteration;
                                                $assignedFactor = $q->factors->first();
                                                $assignedIdentifier = $q->identifier;
                                            @endphp
                                            <div class="question-item mb-4 mt-4 p-4 bg-gray-50 rounded-lg shadow-sm">
                                                <label class="form-label text-lg font-semibold text-gray-700">
                                                    {{ __('messages.Question', [], session()->get('applocale')) }} {{ $question_number }}
                                                </label>
                                                <input 
                                                    type="text" 
                                                    class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                                    name="questions[]" 
                                                    placeholder="Enter question" 
                                                    required
                                                    value="{{ $q->question }}"
                                                >

                                                <label for="identifier" class="mt-4 form-label text-xl font-semibold text-gray-700">{{ __('messages.Question', [], session()->get('applocale'))}} 1: {{ __('messages.Identifier', [], session()->get('applocale'))}}</label>
                                               <select 
                                                    class="form-select mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                                    id="identifier_{{ $index }}" 
                                                    name="identifiers[]" 
                                                    required
                                                >
                                                    <option value="Nan" {{ !$assignedIdentifier ? 'selected' : '' }}>Nan</option>

                                                    @foreach($identifiers as $identifier)
                                                        <option value="{{ $identifier->name }}" {{ ($assignedIdentifier && $assignedIdentifier->name === $identifier->name) ? 'selected' : '' }}>
                                                            {{ $identifier->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                
                                               
                                                <label for="factor" class="mt-4 form-label text-xl font-semibold text-gray-700">{{ __('messages.Question', [], session()->get('applocale'))}} 1: {{ __('messages.Factor', [], session()->get('applocale'))}}</label>
                                               <select 
                                                    class="form-select mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                                    id="factor_{{ $index }}" 
                                                    name="factors[]" 
                                                    required
                                                >
                                                    <option value="Nan" {{ !$assignedFactor ? 'selected' : '' }}>Nan</option>

                                                    @foreach($factors as $factor)
                                                        <option value="{{ $factor->name }}" {{ ($assignedFactor && $assignedFactor->name === $factor->name) ? 'selected' : '' }}>
                                                            {{ $factor->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <label class="form-label text-lg font-semibold text-gray-700 mt-4">
                                                    {{ __('messages.Question', [], session()->get('applocale'))}} 1: {{ __('messages.Type', [], session()->get('applocale'))}}
                                                </label>
                                                <select 
                                                    class="form-select mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                                    name="questionTypes[]" 
                                                    onchange="toggleAdditionalOptions(this, {{ $question_number }})" 
                                                    required
                                                >
                                                    <option value="" disabled {{ $q->type == null ? 'selected' : '' }}>
                                                        {{ __('messages.Choose an option', [], session()->get('applocale')) }}
                                                    </option>
                                                    <option value="number" {{ $q->type == 'number' ? 'selected' : '' }}>
                                                        {{ __('messages.Number', [], session()->get('applocale')) }}
                                                    </option>
                                                    <option value="yes_no" {{ $q->type == 'yes_no' ? 'selected' : '' }}>
                                                        {{ __('messages.Yes/No', [], session()->get('applocale')) }}
                                                    </option>
                                                    <option value="text" {{ $q->type == 'text' ? 'selected' : '' }}>
                                                        {{ __('messages.Text', [], session()->get('applocale')) }}
                                                    </option>
                                                    <option value="scale" {{ $q->type == 'scale' ? 'selected' : '' }}>
                                                        {{ __('messages.Scale', [], session()->get('applocale')) }}
                                                    </option>
                                                    <option value="large_text" {{ $q->type == 'large_text' ? 'selected' : '' }}>
                                                        {{ __('messages.Large Text', [], session()->get('applocale')) }}
                                                    </option>
                                                    <option value="checkboxes" {{ $q->type == 'checkboxes' ? 'selected' : '' }}>
                                                        {{ __('messages.Checkboxes', [], session()->get('applocale')) }}
                                                    </option>
                                                    <option value="multiple_choice" {{ $q->type == 'multiple_choice' ? 'selected' : '' }}>
                                                        {{ __('messages.Multiple Option', [], session()->get('applocale')) }}
                                                    </option>
                                                </select>

                                                <!-- Additional Options Container -->
                                                <div id="additional-options-{{ $question_number }}" class="additional-options mt-4 @if(!$q->placeholder && !$q->rows && !$q->scale && empty($q->options)) d-none @endif">
                                                    @if($q->placeholder)
                                                        <label class="form-label scalesLabel">
                                                            {{ __('messages.Question Placeholder', [], session()->get('applocale')) }}
                                                        </label>
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
                                                        <label class="form-label mt-4 scalesLabel">
                                                            {{ __('messages.Number of Rows', [], session()->get('applocale')) }}
                                                        </label>
                                                        <input type="number" class="form-control" name="rows[]" placeholder="Enter number of rows" value="{{ $q->rows }}">
                                                    @endif
                                                    @if($q->type == 'scale')
                                                        <label class="form-label scalesLabel">
                                                            {{ __('messages.Number of Scales', [], session()->get('applocale')) }}
                                                        </label>
                                                        <input type="number" class="form-control" name="scales[]" value="{{ $q->scale }}" placeholder="Enter number of scales">
                                                        <label class="form-label scalesLabel mt-4">
                                                            {{ __('messages.Min description', [], session()->get('applocale')) }}
                                                        </label>
                                                        <input type="text" class="form-control" name="scalemins[]" value="{{ $q->scalemin }}" placeholder="Enter a short description of the minimum scale">
                                                        <label class="form-label scalesLabel mt-4">
                                                            {{ __('messages.Max description', [], session()->get('applocale')) }}
                                                        </label>
                                                        <input type="text" class="form-control" name="scalemaxs[]" value="{{ $q->scalemax }}" placeholder="Enter a short description of the maximum scale">
                                                    @endif
                                                    @if($q->type == 'checkboxes')
                                                        <div class="checkbox-container">
                                                            <label class="form-label scalesLabel">
                                                                {{ __('messages.Checkbox Options', [], session()->get('applocale')) }}
                                                            </label>
                                                            @foreach($q->options as $c)
                                                                <div class="option-item d-flex align-items-center">
                                                                    <input type="checkbox" disabled class="form-check-input me-2 ml-4">
                                                                    <input 
                                                                        type="text" 
                                                                        style="width:70%; margin-left:50px"
                                                                        class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                                                        name="checkbox[{{ $question_number }}][]" 
                                                                        placeholder="Enter an option" 
                                                                        value="{{ $c }}"
                                                                        required
                                                                    >
                                                                    <button type="button" class="btn btn-danger ms-2 remove-option">
                                                                        {{ __('messages.Remove', [], session()->get('applocale')) }} -
                                                                    </button>
                                                                </div>
                                                            @endforeach
                                                            <button type="button" class="btn btn-primary mt-4 ml-4 add-option">
                                                                {{ __('messages.Add option', [], session()->get('applocale')) }} +
                                                            </button>
                                                        </div>
                                                    @endif
                                                    @if($q->type == 'multiple_choice')
                                                        <div class="radio-container">
                                                            <label class="form-label scalesLabel">
                                                                {{ __('messages.Multiple Options', [], session()->get('applocale')) }}
                                                            </label>
                                                            @foreach($q->options as $m)
                                                                <div class="option-item d-flex align-items-center">
                                                                    <input type="radio" disabled class="form-check-input me-2 ml-4">
                                                                    <input 
                                                                        type="text" 
                                                                        style="width:70%; margin-left:50px"
                                                                        class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" 
                                                                        name="radio[{{ $question_number }}][]" 
                                                                        placeholder="Enter an option" 
                                                                        value="{{ $m }}"
                                                                        required
                                                                    >
                                                                    <button type="button" class="btn btn-danger ms-2 remove-option">
                                                                        {{ __('messages.Remove', [], session()->get('applocale')) }} -
                                                                    </button>
                                                                </div>
                                                            @endforeach
                                                            <button type="button" class="btn btn-primary mt-4 ml-4 add-option">
                                                                {{ __('messages.Add option', [], session()->get('applocale')) }} +
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>

                                                @if($question_number > 1)
                                                    <!-- Remove Question Button -->
                                                    <div style="display: flex; justify-content: flex-start;" dir="rtl">
                                                        <button type="button" class="btn btn-danger mt-4 mb-2 remove-question" onclick="removeQuestion(this)">
                                                            {{ __('messages.Remove Question', [], session()->get('applocale')) }} {{ $question_number }}
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                             
                                <!-- Form Actions -->
                                <div class="row">
                                    <div class="col-6 text-left">
                                        <button type="button" class="btn btn-primary mb-2 px-6 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow-md transition duration-300" onclick="addAnotherQuestion()">
                                            {{ __('messages.Add Question', [], session()->get('applocale')) }} +
                                        </button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="submit" class="btn btn-question px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-md transition duration-300">
                                            {{ __('messages.Update Form', [], session()->get('applocale')) }}
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
        // Utility: Extract question number from container ID (expects format "additional-options-X")
        function getQuestionNumberFromContainer(container) {
            if (container && container.id) {
                const parts = container.id.split('-');
                return parts[2] || '';
            }
            return '';
        }

        // Attach a remove handler for option buttons
        function addRemoveOptionHandler(button) {
            button.addEventListener('click', function() {
                button.closest('.option-item').remove();
            });
        }

        // Dynamically attach event handlers for "Add option" buttons
        function addDynamicOptionHandlers(container, inputType, countQuestions) {
            // If countQuestions not passed, extract it from the container's ID
            if (!countQuestions) {
                countQuestions = getQuestionNumberFromContainer(container);
            }
            const addOptionButton = container.querySelector('.add-option');
            if (addOptionButton) {
                addOptionButton.addEventListener('click', function() {
                    const newOption = document.createElement('div');
                    newOption.classList.add('option-item', 'd-flex', 'align-items-center');
                    newOption.innerHTML = `
                        <input type="${inputType}" disabled class="form-check-input me-2 ml-4">
                        <input type="text" style="width:70%; margin-left:50px" class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" name="${inputType}[${countQuestions}][]" placeholder="Enter an option" required>
                        <button type="button" class="btn btn-danger ms-2 remove-option">Remove -</button>
                    `;
                    container.querySelector(`.${inputType}-container`).insertBefore(newOption, addOptionButton);
                    addRemoveOptionHandler(newOption.querySelector('.remove-option'));
                });
            }
            // Attach remove handler for any existing option buttons
            container.querySelectorAll('.remove-option').forEach(function(removeButton) {
                addRemoveOptionHandler(removeButton);
            });
        }

        // Show additional options based on the selected question type
        function toggleAdditionalOptions(select, questionNumber) {
            const additionalOptions = select.closest('.question-item').querySelector('.additional-options');
            additionalOptions.innerHTML = ''; // Clear previous content

            // If question number not provided, extract it from container ID
            if (!questionNumber) {
                questionNumber = getQuestionNumberFromContainer(additionalOptions);
            }

            if (select.value === 'scale') {
                additionalOptions.innerHTML = `
                    <label class="form-label scalesLabel">Number of Scales</label>
                    <input type="number" class="form-control" name="scales[]" placeholder="Enter number of scales">
                    <label class="form-label scalesLabel mt-4">Min description</label>
                    <input type="text" class="form-control" name="scalemins[]" placeholder="Enter a short description of the minimum scale">
                    <label class="form-label scalesLabel mt-4">Max description</label>
                    <input type="text" class="form-control" name="scalemaxs[]" placeholder="Enter a short description of the maximum scale">
                `;
                additionalOptions.classList.remove('d-none');
            } else if (select.value === 'large_text') {
                additionalOptions.innerHTML = `
                    <label class="form-label scalesLabel">Question Placeholder</label>
                    <input type="text" class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" name="placeholders[]" placeholder="Enter the placeholder of the question" required>
                    <label class="form-label scalesLabel mt-4">Number of Rows</label>
                    <input type="number" class="form-control" name="rows[]" placeholder="Enter number of rows">
                `;
                additionalOptions.classList.remove('d-none');
            } else if (select.value === 'text' || select.value === 'number') {
                additionalOptions.innerHTML = `
                    <label class="form-label scalesLabel">Question Placeholder</label>
                    <input type="text" class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" name="placeholders[]" placeholder="Enter the placeholder of the question" required>
                `;
                additionalOptions.classList.remove('d-none');
            } else if (select.value === 'multiple_choice' || select.value === 'checkboxes') {
                const inputType = select.value === 'multiple_choice' ? 'radio' : 'checkbox';
                additionalOptions.innerHTML = `
                    <div class="${inputType}-container">
                        <label class="form-label scalesLabel">
                            ${inputType === 'radio' ? 'Multiple Choice Options' : 'Checkbox Options'}
                        </label>
                        <div class="option-item d-flex align-items-center">
                            <input type="${inputType}" disabled class="form-check-input me-2 ml-4">
                            <input type="text" style="width:70%; margin-left:50px" class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" name="${inputType}[${questionNumber}][]" placeholder="Enter an option" required>
                            <button type="button" class="btn btn-danger ms-2 remove-option">Remove -</button>
                        </div>
                        <button type="button" class="btn btn-primary mt-4 ml-4 add-option">Add option +</button>
                    </div>
                `;
                // Bind dynamic option handlers after DOM update
                setTimeout(() => {
                    addDynamicOptionHandlers(additionalOptions, inputType, questionNumber);
                }, 0);
                additionalOptions.classList.remove('d-none');
            } else {
                additionalOptions.classList.add('d-none');
            }
        }

        // Remove a question from the list
        function removeQuestion(button) {
            button.closest('.question-item').remove();
            // Optionally update question numbering if needed
        }

        // Global counter for new questions (starting from the current count)
        var countQuestions = Number({{ count($form->questions) }});
        function addAnotherQuestion() {
            const questionsSection = document.getElementById('sortable-questions');
            const newQuestionNumber = countQuestions + 1;
            const newQuestion = document.createElement('div');
            const factors = @json($factors);
            const identifiers = @json($identifiers);

            newQuestion.classList.add('question-item', 'mb-3', 'p-4', 'bg-gray-50', 'rounded-lg', 'shadow-sm');
            let factorOptions = `<option value="No">Nan</option>`;
            factors.forEach(factor => {
                factorOptions += `<option value="${factor.name}">${factor.name}</option>`;
            });

             let identifierOptions = `<option value="No">Nan</option>`;
            identifiers.forEach(identifier => {
                identifierOptions += `<option value="${identifier.name}">${identifier.name}</option>`;
            });

newQuestion.innerHTML = `
    <label class="form-label text-lg font-semibold text-gray-700">Question ${newQuestionNumber}</label>
    <input type="text" class="form-control mt-2 p-3 border border-gray-300 rounded-lg w-full" name="questions[]" placeholder="Enter question" required>

   
    <label class="form-label text-lg font-semibold text-gray-700 mt-4">{{ __('messages.Question', [], session()->get('applocale'))}} ${countQuestions+1}: {{ __('messages.Identifier', [], session()->get('applocale'))}}</label>
    <select class="form-select mt-2 p-3 border border-gray-300 rounded-lg w-full" name="identifier[]" required>
        ${identifierOptions}
    </select>



        <label class="form-label text-lg font-semibold text-gray-700 mt-4">{{ __('messages.Question', [], session()->get('applocale'))}} ${countQuestions+1}: {{ __('messages.Factor', [], session()->get('applocale'))}}</label>
    <select class="form-select mt-2 p-3 border border-gray-300 rounded-lg w-full" name="factor[]" required>
        ${factorOptions}
    </select>

    <label class="form-label text-lg font-semibold text-gray-700 mt-4">{{ __('messages.Question', [], session()->get('applocale'))}} ${countQuestions+1}: {{ __('messages.Type', [], session()->get('applocale'))}}</label>
    <select class="form-select mt-2 p-3 border border-gray-300 rounded-lg w-full" name="questionTypes[]" onchange="toggleAdditionalOptions(this, ${newQuestionNumber})" required>
        <option value="" disabled selected>Choose an option</option>
        <option value="number">Number</option>
        <option value="yes_no">Yes/No</option>
        <option value="text">Text</option>
        <option value="scale">Scale</option>
        <option value="large_text">Large Text</option>
        <option value="checkboxes">Checkboxes</option>
        <option value="multiple_choice">Multiple Option</option>
    </select>

  

    <div id="additional-options-${newQuestionNumber}" class="additional-options mt-4 d-none"></div>
    <div style="display: flex; justify-content: flex-start;" dir="rtl">
        <button type="button" class="btn btn-danger mt-4 mb-2 remove-question" onclick="removeQuestion(this)">Remove Question ${newQuestionNumber}</button>
    </div>
`;
            questionsSection.appendChild(newQuestion);
            countQuestions++;
        }

        // Initialize SortableJS for reordering questions
        new Sortable(document.getElementById('sortable-questions'), {
            animation: 150,
            handle: '.question-item',
            onEnd: function (evt) {
                console.log('New order:', evt.to);
            }
        });

        // On page load, attach remove option handlers for existing buttons
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.remove-option').forEach(function(removeButton) {
                addRemoveOptionHandler(removeButton);
            });
            // For any pre-existing additional options containers that are visible, attach dynamic option handlers
            document.querySelectorAll('.additional-options').forEach(function(container) {
                if (!container.classList.contains('d-none')) {
                    let questionNumber = getQuestionNumberFromContainer(container);
                    const innerContainer = container.querySelector('.checkbox-container, .radio-container');
                    if (innerContainer) {
                        let inputType = innerContainer.classList.contains('radio-container') ? 'radio' : 'checkbox';
                        addDynamicOptionHandlers(container, inputType, questionNumber);
                    }
                }
            });
        });
    </script>
    @endsection
</x-app-layout>
