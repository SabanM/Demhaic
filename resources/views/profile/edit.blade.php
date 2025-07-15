

    <x-app-layout>
    @section('style')
    <style>
        .dashcard {
            transition: transform 2s ease; /* Smooth transition for scaling */
        }
        .dashcard:hover{
           scale:1.05;
           transition: transform 0.3s ease; 
           cursor:pointer;
        }
    </style>
    @endsection
    @section('headertitle')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('messages.Profile', [], session()->get('applocale'))}}
        </h2>
    @endsection
    @section('maincontent')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.initial-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
    @endsection
</x-app-layout>
