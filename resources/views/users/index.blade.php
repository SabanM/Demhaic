<x-app-layout>
    @section('headertitle')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Users') }}                          
        </h2>
    @endsection

    @section('maincontent')
      
    <div class="max-w-7xl mx-auto sm:px-8 mt-2 lg:px-10">
    <div class="container">
        <div class="bg-white p-6 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="row mb-3">
                <!-- Left Part: Content (col-md-10) -->
                <div class="col-md-10">
                    <p class="c-grey h4">{{ __('messages.List of Users', [], session()->get('applocale'))}}</p>
                </div>
                <!-- Right Part: Button (col-md-2) -->
                <div class="col-md-2 d-flex justify-content-end align-items-start">
                    <!-- Trigger the modal with a button -->
                    <!--<button class="btn btn-primary" data-toggle="modal" data-target="#taskModal">Add New +</button>-->
                </div>
            </div>

            <div class="row">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 20%;"> ID</th>
                            <th style="width: 20%;">{{ __('messages.Name', [], session()->get('applocale'))}}</th>
                            <th style="width: 20%;">{{ __('messages.Username', [], session()->get('applocale'))}}</th>
                            <th style="width: 20%;">{{ __('messages.Created at', [], session()->get('applocale'))}}</th>
                            <th style="width: 40%;" class="text-right">{{ __('messages.Actions', [], session()->get('applocale'))}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td class="text-right">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">{{ __('messages.Edit', [], session()->get('applocale'))}}</a>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this user?');">{{ __('messages.Delete', [], session()->get('applocale'))}}</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


       
    @endsection

    @section('scripts')

    @endsection
</x-app-layout>
