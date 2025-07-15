<x-app-layout>
    @section('headertitle')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">

              {{ __('messages.Reflections', [], session()->get('applocale'))}}                       
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
                    <p class="c-grey h4">{{ __('messages.My reflections', [], session()->get('applocale'))}}</p>
                </div>
                <!-- Right Part: Button (col-md-2) -->
                <div class="col-md-2 d-flex justify-content-end align-items-start">
                    <!-- Trigger the modal with a button -->
                    <button class="btn btn-primary" data-toggle="modal" data-target="#weeklyModal" class="btn bg-green text-white">{{ __('messages.Add new', [], session()->get('applocale'))}} +</button>
                </div>

            
            </div>

            <!-- Diaries List -->
            <div class="mt-4">
                @if ($entries->isEmpty())
                    <p class="text-gray-500">{{ __('messages.You have no reflections entries yet', [], session()->get('applocale'))}}.</p>
                @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-nowrap"  style="width: 10%;">#</th>
                                <th class="text-nowrap"  style="width: 30%;">{{ __('messages.Starting date', [], session()->get('applocale'))}}</th>
                                <th class="text-nowrap"  style="width: 30%;">{{ __('messages.Finishing date', [], session()->get('applocale'))}}</th>
                                <th class="text-nowrap"  class="text-right" style="width: 60%; padding-right: 40px;">{{ __('messages.Actions', [], session()->get('applocale'))}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($entries as $index => $entry)
                                @php
                                    $startingDateDetail = null;
                                    $finishingDateDetail= null;
                                    $details = json_decode($entry->entry, true);
                                    foreach ($details as $key => $value) {

                                        if ($key === 'finishing_date') {
                                            $finishingDateDetail = $value;
                                            break;
                                        }
                                    }
                                    foreach ($details as $key => $value) {
                                        if ($key === 'starting_date') {
                                            $startingDateDetail = $value;
                                            break;
                                        }
                                    }
                                @endphp
                                <tr>
                                    <td class="text-nowrap" >{{ $index + 1 }}</td>
                                    <td class="text-nowrap" >{{ \Carbon\Carbon::parse($startingDateDetail)->format('d/m/Y') ?? '' }}</td>
                                    <td class="text-nowrap" >{{ \Carbon\Carbon::parse($finishingDateDetail)->format('d/m/Y') ?? '' }}</td>
                                    <td class="text-right text-nowrap">
                                        <div class="d-flex justify-content-end gap-2">
                                            <button 
                                                class="btn btn-sm btn-info" 
                                                data-toggle="modal" 
                                                data-target="#entryModal{{ $entry->id }}">
                                                <i class="fa fa-eye"></i> {{ __('messages.View', [], session()->get('applocale'))}}
                                            </button>
                                            <button 
                                                class="btn btn-sm btn-warning" 
                                                data-toggle="modal" 
                                                data-target="#editEntryModal{{ $entry->id }}">
                                                <i class="fa fa-edit"></i> {{ __('messages.Edit', [], session()->get('applocale'))}}
                                            </button>
                                            <form action="{{ route('diaries.destroy', ['id' => $entry->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this entry?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i> {{ __('messages.Delete', [], session()->get('applocale'))}}
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <!-- Modals for View and Edit go here -->

                                <!-- Modal for Viewing Details -->
                                <div class="modal fade" id="entryModal{{ $entry->id }}" tabindex="-1" role="dialog" aria-labelledby="entryModalLabel{{ $entry->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center h5" id="entryModalLabel{{ $entry->id }}">{{ __('messages.Your reflection between', [], session()->get('applocale'))}} {{ \Carbon\Carbon::parse($startingDateDetail)->format('d/m/Y') ?? '' }} {{ __('messages.and', [], session()->get('applocale'))}}  {{ \Carbon\Carbon::parse($finishingDateDetail)->format('d/m/Y') ?? '' }} </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                
                                                <div class="container">
                                                    @foreach ($details as $question => $answer)
                                                    
                                                    @if ($question !== '_token')
                                                            @php
                                                                $matchedQuestion = collect($weeklyFormQuestions)->firstWhere('question', $question);
                                                            @endphp

                                                        <div class="row mb-3">
                                                            <div class="col-md-6 font-weight-bold">
                                                                @if($question === "starting_date")
                                                                    {{ __('messages.Starting date', [], session()->get('applocale'))}}
                                                                @elseif($question === "finishing_date")
                                                                    {{ __('messages.Finishing date', [], session()->get('applocale'))}}
                                                                @else
                                                                {{ $question }}
                                                                @endif
                                                            </div>
                                                            <div class="col-md-6 text-secondary">
                                                            @if ($matchedQuestion && $matchedQuestion->type === 'scale')
                                                            {{ $answer }} / {{ $matchedQuestion->scale }}
                                                           
                                                            @else
                                                            {{ is_array($answer) ?  implode('; ', $answer) : $answer }} 
                                                            @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.Close', [], session()->get('applocale'))}}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Modal -->

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editEntryModal{{ $entry->id }}" tabindex="-1" role="dialog" aria-labelledby="editEntryModalLabel{{ $entry->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-center h5" id="editEntryModalLabel{{ $entry->id }}">{{ __('messages.Edit Reflection Entry for', [], session()->get('applocale'))}} {{ \Carbon\Carbon::parse($entry->created_at)->format('d/m/Y') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('diaries.update', $entry->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="container">
                                                    @foreach ($details as $question => $answer)
                                                    @if ($question !== '_token')
                                                        @php
                                                            $matchedQuestion = collect($weeklyFormQuestions)->firstWhere('question', $question);
                                                            $scaleMax = $matchedQuestion ? $matchedQuestion->scale : null;
                                                        @endphp

                                                        <div class="row mb-3">
                                                            <div class="col-md-6 font-weight-bold">
                                                                {{ $question }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                @if ($matchedQuestion && $matchedQuestion->type === 'scale')
                                                                    <input type="number" class="form-control" name="details[{{ $question }}]" value="{{ $answer }}" max="{{ $scaleMax }}">
                                                                @else
                                                                    <input type="text" class="form-control" name="details[{{ $question }}]" value="{{ is_array($answer) ? implode('; ', $answer) : $answer }}">
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">{{ __('messages.Save Changes', [], session()->get('applocale'))}}</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('messages.Close', [], session()->get('applocale'))}}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Edit Modal -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


     

       
    @endsection

    @section('scripts')

    @endsection
</x-app-layout>
