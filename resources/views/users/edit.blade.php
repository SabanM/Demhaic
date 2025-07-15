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
                    <p class="c-grey h4">{{ __('messages.Edit User', [], session()->get('applocale'))}} {{ $user->name}}</p>
                </div>
                <!-- Right Part: Button (col-md-2) -->
                <div class="col-md-2 d-flex justify-content-end align-items-start">
                    <!-- Placeholder for additional buttons if needed -->
                </div>
            </div>

            <div class="row container">
                <form action="{{ route('users.update', $user->id) }}" method="POST" class="w-100">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-3">
                        <label for="id">ID</label>
                        <input type="text" class="form-control" id="id" name="id" value="{{ $user->id }}" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">{{ __('messages.Name', [], session()->get('applocale'))}}</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="username">{{ __('messages.Username', [], session()->get('applocale'))}}</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">{{ __('messages.Email', [], session()->get('applocale'))}}</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                    </div>
                    <div class="form-group mb-3">
                        <label for="admin">{{ __('messages.Admin', [], session()->get('applocale'))}}</label>
                        <select class="form-control" id="admin" name="admin">
                            <option value="0" {{ $user->admin == 0 ? 'selected' : '' }}>{{ __('messages.No', [], session()->get('applocale'))}}</option>
                            <option value="1" {{ $user->admin == 1 ? 'selected' : '' }}>{{ __('messages.Yes', [], session()->get('applocale'))}}</option>
                        </select>
                    </div>
                    <h3 class="h5 mt-4 mb-4">{{ __('messages.Update the password', [], session()->get('applocale'))}}</h3>
                    <div class="form-group mb-3">
                        <label for="created_at">{{ __('messages.Password', [], session()->get('applocale'))}}</label>
                        <input type="text" class="form-control" id="password" name="password" value="">
                    </div>
                  
                    <div class="form-group mb-3">
                        <label for="updated_at">{{ __('messages.Password confirmation', [], session()->get('applocale'))}}</label>
                        <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" value="">
                    </div>
                    <div class="form-group d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">{{ __('messages.Save Changes', [], session()->get('applocale'))}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



       
    @endsection

    @section('scripts')

    @endsection
</x-app-layout>
