<x-app-layout>
    @section('headertitle')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Edit diary') }}                          
        </h2>
    @endsection

    @section('maincontent')
      
        <!-- New tasks -->
<div class="max-w-7xl mx-auto sm:px-8 mt-2 lg:px-10">
    <div class="container">
        <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
        <form method="POST" action="{{ route('diaries.update', $entry->id) }}">
            @csrf
            @method('PUT')

            <div class="modal-body">
                <div class="form-group">
                    <label for="entry">{{('Entry Details')}}:</label>
                    <textarea id="entry" class="form-control" name="entry" rows="5" required>{{ old('entry', $entry->entry) }}</textarea>
                </div>

                <!-- Additional form fields can go here -->
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{('Save Changes')}}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{('Close')}}</button>
            </div>
        </form>

        </div>
    </div>
</div>


     

       
    @endsection

    @section('scripts')

    @endsection
</x-app-layout>
