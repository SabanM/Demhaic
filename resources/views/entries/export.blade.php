<div class="container-fluid">
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark text-center">
                <tr>
                    <th class="text-nowrap" style="width: 10%;">{{ __('messages.Entry date', [], session()->get('applocale'))}}</th>
                    <th class="text-nowrap" style="width: 15%;">{{ __('messages.Username', [], session()->get('applocale'))}}</th>
                    <th class="text-nowrap" style="width: 15%;">{{ __('messages.Form', [], session()->get('applocale'))}}</th>
                    <th class="text-nowrap" style="width: 30%;">{{ __('messages.Question', [], session()->get('applocale'))}}</th>
                    <th class="text-nowrap" style="width: 30%;">{{ __('messages.Answer', [], session()->get('applocale'))}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($entries as $entry)
                    @php
                        $details = json_decode($entry->entry, true);
                        $entryDateDetail = null;
                        foreach ($details as $key => $value) {
                                    if ($key === 'Entry Date') {
                                        $entryDateDetail = $value;
                                        break;
                                    }
                                }
                    @endphp

                    @foreach ($details as $question => $answer)

                       

                        @if ($question !== '_token' && $question !== 'Entry Date')
                            @php
                                $matchedQuestion = collect($questions)->firstWhere('question', $question);
                                
                            @endphp
                            <tr>
                                <td class="text-center" style="width: 10%;">{{ $entryDateDetail ?? $entry->created_at->format('Y-m-d') }}</td>
                                <td class="text-center"  style="width: 15%;">{{ $entry->user->username }}</td>
                                <td class="text-center"  style="width: 15%;">{{ $entry->dform->name }}</td>
                                <td class="fw-bold" style="width: 30%;">{{ $question }}</td>
                                <td style="width: 30%;">
                                   
                                    @if ($matchedQuestion && $matchedQuestion->type === 'scale')
                                        {{ ($answer === null || $answer === '') ? '1' : $answer }} / {{ $matchedQuestion->scale }}
                                    @elseif ($matchedQuestion && $matchedQuestion->type === 'yes_no')
                                        {{ $answer === 'yes' ? '1' : ($answer === 'no' ? '0' : 'no answer') }}
                                    @else
                                        {{ empty($answer) ? 'no answer' : preg_replace('/[^A-Za-z0-9\s\-\_\.\(\)]/', '', str_replace('""', '()', is_array($answer) ? implode('; ', $answer) : $answer)) }}

                                    @endif
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
                       