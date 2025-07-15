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
                        <div class="col-md-8">
                            <p class="c-grey h4">{{ __('messages.Entries', [], session()->get('applocale'))}}</p>
                        </div>
                        <!-- Right Part: Button (col-md-2) -->
                        <div class="col-md-2 d-flex justify-content-end align-items-start">
                            <!-- Trigger the modal with a button -->
                            <a href="{{ route('entries.export', ['type' => 'excel']) }}" class="btn btn-block bg-green"><i class="fa fa-file-excel mr-2"></i>{{ __('messages.Export Excel', [], session()->get('applocale'))}}</a>
                        </div>

                        <div class="col-md-2 d-flex justify-content-end align-items-start">
                            <!-- Trigger the modal with a button -->
                            <a href="{{ route('entries.export', ['type' => 'csv']) }}" class="btn btn-block btn-info"><i class="fa fa-file-csv mr-2"></i>{{ __('messages.Export CSV', [], session()->get('applocale'))}}</a>
                        </div>
                    </div>
                    
                   
                </div>
            </div>
        </div>

        <div class="max-w-12xl mx-auto sm:px-8 mt-2 lg:px-10">
            <div class="container">
                <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-dark text-center">
                                    <tr>
                                        <th class="text-nowrap" style="width: 10%;">{{ __('messages.Entry date', [], session()->get('applocale'))}}</th>
                                        <th class="text-nowrap" style="width: 15%;">{{ __('messages.Username', [], session()->get('applocale'))}}</th>
                                        <th class="text-nowrap" style="width: 15%;">{{ __('messages.Form', [], session()->get('applocale'))}}</th>
                                        <th class="text-nowrap" style="width: 60%;">{{ __('messages.Questions and Answers', [], session()->get('applocale'))}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($entries as $entry)

                                    @php
                                        $entryDateDetail = null;
                                        $details = json_decode($entry->entry, true);
                                        foreach ($details as $key => $value) {
                                            if ($key === 'Entry Date') {
                                                $entryDateDetail = $value;
                                                break;
                                            }
                                        }
                                    @endphp
                                        @php
                                            $details = json_decode($entry->entry, true);
                                        @endphp
                                        <tr>
                                            <td class=" text-nowraptext-center" style="width: 10%;">{{ $entryDateDetail ?? $entry->created_at->format('Y-m-d') }}</td>
                                            <td class="text-nowrap text-center"  style="width: 15%;">{{ $entry->user->username }}</td>
                                            <td class="text-nowrap text-center"  style="width: 15%;">{{ $entry->dform->name }}</td>
                                            <td  style="width: 60%;">
                                                <table class="table table-borderless mb-0">
                                                    <tbody>
                                                        @foreach ($details as $question => $answer)
                                                            @if ($question !== '_token' && $question !== 'Entry Date')
                                                                @php
                                                                    $matchedQuestion = collect($questions)->firstWhere('question', $question);
                                                                @endphp
                                                                <tr>
                                                                    <td class="fw-bold" style="width: 50%;">{{ $question }}</td>
                                                                    <td>
                                                                        @if ($matchedQuestion && $matchedQuestion->type === 'scale')
                                                                            {{ $answer }} / {{ $matchedQuestion->scale }}
                                                                        @else
                                                                            {{ is_array($answer) ? implode('; ', $answer) : $answer }} 
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
    {{ $entries->links() }}
</div>
                    </div>
                </div>
            </div>
        </div>

    @endsection

    @section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>


  
    @endsection
</x-app-layout>
