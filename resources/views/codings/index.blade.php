<x-app-layout>
    @section('headertitle')
        <h1>TEST</h1>
    @endsection

 @section('maincontent')
      
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
                                        <th class="text-nowrap" style="width: 15%;">{{ __('messages.Diary', [], session()->get('applocale'))}}</th>
                                        <!--<th class="text-nowrap" style="width: 60%;">{{ __('messages.Questions and Answers', [], session()->get('applocale'))}}</th>-->
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
                                              
                                                        @php
                                                            $filteredAnswer = null;
                                                        @endphp

                                                        @foreach ($details as $question => $answer)
                                                            @if ($question !== '_token' && $question !== 'Entry Date')
                                                                @php
                                                                    $matchedQuestion = collect($questions)->firstWhere('question', $question);
                                                                @endphp

                                                                @if (
                                                                    $matchedQuestion &&
                                                                    $matchedQuestion->type === 'large_text'  &&
                                                                    (Str::contains(strtolower($matchedQuestion->question), 'this day') ||
                                                                    Str::contains(strtolower($matchedQuestion->question), 'este día') ||
                                                                    Str::contains(strtolower($matchedQuestion->question), 'today') ||
                                                                    Str::contains(strtolower($matchedQuestion->question), 'hoy'))
                                                                )
                                                                    
                                                                    {{ $matchedQuestion->question}}
                                                                    <br>
                                                                    {{$answer}}
                                                                
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                   
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

        @endsection
</x-app-layout>