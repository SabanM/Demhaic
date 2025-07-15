<x-app-layout>
    @section('headertitle')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Diaries') }}                          
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
                            <p class="c-grey h4">My diaries</p>
                        </div>
                        <!-- Right Part: Button (col-md-2) -->
                        <div class="col-md-2 d-flex justify-content-end align-items-start">
                            <!-- Trigger the modal with a button -->
                            <button class="btn btn-primary" data-toggle="modal" data-target="#taskModal">Add new +</button>
                        </div>
                    </div>
                    
                 
                </div>
            </div>
        </div>

     

       
    @endsection

    @section('scripts')

    @endsection
</x-app-layout>
