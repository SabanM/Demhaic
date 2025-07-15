  <!-- Sidebar -->
  <!--<aside :class="isSidebarOpen ? 'w-64' : 'w-20'" style="background-color: #0056b3; height:100%" class="bg-gray-800 text-white min-h-screen transition-all duration-300">-->
  <aside 
   x-data="{ isSidebarOpen: true, openMenu: null }"
    :class="isSidebarOpen ? 'w-64' : 'w-20'" 
    class="fixed top-0 left-0 z-50 bg-gray-800 text-white h-screen min-h-screen transition-all duration-300"
    style="background-color: #0056b3; margin-top:65px">
    <div class="p-4 flex items-center justify-between">
        <!-- Centered Title -->
        <h4 class="flex-grow text-center" :class="isSidebarOpen ? 'block' : 'hidden'">DEMHAIC</h4>
        
        <!-- Toggle Button -->
        <button @click="isSidebarOpen = !isSidebarOpen" class="text-white focus:outline-none">
            <i :class="isSidebarOpen ? 'fas fa-chevron-left' : 'fas fa-chevron-right'"></i>
        </button>
    </div>

     <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
       

        <!-- Responsive Settings Options -->
        <div style="background-color: white;" class="pb-1 border-t border-gray-200">
          
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('messages.Profile', [], session()->get('applocale')) }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('messages.Log Out', [], session()->get('applocale')) }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

    <ul class="m2-6">
        <a href="{{ route('dashboard') }}"  class="flex nodec full-width items-center hover:bg-gray-700 hover:text-white ">
            <li class="h-12 px-6 py-2 hover:bg-gray-700 flex items-center"
                :class="{ 'liactive': '{{ Route::currentRouteName() == 'dashboard' }}' }">
                    <i class="fas fa-home mr-3" :class="isSidebarOpen ? 'block' : 'hidden'"></i>
                    <p class="ml-4" :class="isSidebarOpen ? 'block' : 'hidden'">{{ __('messages.Dashboard', [], session()->get('applocale'))}}</p>
            </li>
        </a>
        <a href="{{ route('diaries') }}" class="flex nodec full-width items-center hover:bg-gray-700 hover:text-white ">
            <li class="h-12  px-6 py-2 hover:bg-gray-700 text-whitehover:text-white flex items-center"
                :class="{ 'liactive': '{{ Route::currentRouteName() == 'diaries' }}' }">
                <i class="fas fa-book-open mr-3" :class="isSidebarOpen ? 'block' : 'hidden'"></i>
                <p class="ml-4" :class="isSidebarOpen ? 'block' : 'hidden'">{{ __('messages.My diaries', [], session()->get('applocale'))}}</p>
             </li>
        </a>

        <a href="{{ route('reflections') }}" class="flex nodec full-width items-center hover:bg-gray-700 hover:text-white ">
            <li class="h-12  px-6 py-2 hover:bg-gray-700 hover:text-white flex items-center"
                :class="{ 'liactive': '{{ Route::currentRouteName() == 'reflections' }}' }">
                <i class="fas fa-lightbulb mr-3" :class="isSidebarOpen ? 'block' : 'hidden'"></i>
                <p class="ml-4" :class="isSidebarOpen ? 'block' : 'hidden'">{{ __('messages.My reflections', [], session()->get('applocale'))}}</p>
             </li>
        </a>

        <a href="{{ route('tasks') }}" class="flex nodec full-width items-center hover:bg-gray-700 hover:text-white ">
            <li class="h-12  px-6 py-2 flex items-center"
                :class="{ 'liactive': '{{ Route::currentRouteName() == 'tasks' }}' }">
                <i class="fas fa-tasks mr-3" :class="isSidebarOpen ? 'block' : 'hidden'"></i>
                <p class="ml-4" :class="isSidebarOpen ? 'block' : 'hidden'">{{ __('messages.Tasks', [], session()->get('applocale'))}}</p>
            </li>
        </a>

        <a href="{{ route('milestones') }}" class="flex nodec full-width items-center hover:bg-gray-700 hover:text-white ">
            <li class="h-12  px-6 py-2 hover:bg-gray-700 hover:text-white flex items-center"
                :class="{ 'liactive': '{{ Route::currentRouteName() == 'milestones' }}' }">
                <i class="fas fa-flag-checkered mr-3" :class="isSidebarOpen ? 'block' : 'hidden'"></i>
                <p class="ml-4" :class="isSidebarOpen ? 'block' : 'hidden'">{{ __('messages.Milestones', [], session()->get('applocale'))}}</p>
            </li>
        </a>

        <a href="{{ route('thesismap') }}" class="flex nodec full-width items-center hover:bg-gray-700 hover:text-white ">
            <li class="h-12  px-6 py-2 hover:bg-gray-700 hover:text-white flex items-center"
                :class="{ 'liactive': '{{ Route::currentRouteName() == 'thesismap' }}' }">
                    <i class="fas fa-map mr-3" :class="isSidebarOpen ? 'block' : 'hidden'"></i>
                    <p class="ml-4" :class="isSidebarOpen ? 'block' : 'hidden'">{{ __('messages.Thesis Map', [], session()->get('applocale'))}}</p>
            </li>
        </a>

        <a href="{{ route('progress') }}" class="flex nodec full-width items-center hover:bg-gray-700 hover:text-white ">
         <li class="h-12  px-6 py-2 hover:bg-gray-700 hover:text-white flex items-center"
           :class="{ 'liactive': '{{ Route::currentRouteName() == 'progress' }}' }">
                <i class="fas fa-chart-line mr-3" :class="isSidebarOpen ? 'block' : 'hidden'"></i>
                <p class="ml-4" :class="isSidebarOpen ? 'block' : 'hidden'">{{ __('messages.Progress', [], session()->get('applocale'))}}</p>
            </li>
        </a>

        <!--<a onclick="pagesoon()" class="flex nodec full-width items-center hover:bg-gray-700 hover:text-white ">
            <li class="h-12 px-6 py-2 hover:bg-gray-700 flex items-center">
                <i class="fas fa-lightbulb mr-3" :class="isSidebarOpen ? 'block' : 'hidden'"></i>
                <p class="ml-4" :class="isSidebarOpen ? 'block' : 'hidden'">{{ __('messages.Insights', [], session()->get('applocale'))}}</p>
            </li>
        </a>
        
        <a onclick="pagesoon()" class="flex nodec full-width items-center hover:bg-gray-700 hover:text-white ">
            <li class="h-12 px-6 py-2 hover:bg-gray-700 flex items-center">
                <i class="fas fa-file-alt mr-3" :class="isSidebarOpen ? 'block' : 'hidden'"></i>
                <p class="ml-4" :class="isSidebarOpen ? 'block' : 'hidden'">{{ __('messages.New Papers', [], session()->get('applocale'))}}</p>
            </li>
        </a>

        <a onclick="pagesoon()" class="flex nodec full-width items-center hover:bg-gray-700 hover:text-white ">
            <li class="h-12 px-6 py-2 hover:bg-gray-700 flex items-center">
                <i class="fas fa-cog mr-3" :class="isSidebarOpen ? 'block' : 'hidden'"></i>
                <p class="ml-4" :class="isSidebarOpen ? 'block' : 'hidden'">{{ __('messages.Settings', [], session()->get('applocale'))}}</p>
            </li>
        </a>-->

      
        @if(Auth::user()->admin)
        <li class="mt-4" style="border:1px solid grey">
            <p align="center" class="h6 mt-2">{{ __('messages.Admin options', [], session()->get('applocale'))}}</p>
        </li>
        <a href="{{ route('users.index') }}" class="flex nodec full-width items-center hover:bg-gray-700 hover:text-white ">
            <li class="h-12 px-6 py-2 hover:bg-gray-700 flex items-center">
                <i class="fas fa-users mr-3" :class="isSidebarOpen ? 'block' : 'hidden'"></i>
                <p class="ml-4" :class="isSidebarOpen ? 'block' : 'hidden'">{{ __('messages.Users', [], session()->get('applocale'))}}</p>
            </li>
        </a>
       <!-- Forms parent item (collapsible group) -->
        <li class="h-12 px-6 py-2 hover:bg-gray-700 flex items-center cursor-pointer"
            @click="openMenu === 'forms' ? openMenu = null : openMenu = 'forms'">
            <i class="fas fa-folder-open mr-3" :class="isSidebarOpen ? 'block' : 'hidden'"></i>
            <p class="ml-4 flex-grow" :class="isSidebarOpen ? 'block' : 'hidden'">{{ __('messages.Forms', [], session()->get('applocale'))}}</p>
            <i class="fas fa-chevron-down" :class="{ 'rotate-180': openMenu === 'forms', 'hidden': !isSidebarOpen }"></i>
        </li>

        <!-- Submenu items -->
        <ul x-show="openMenu === 'forms'" x-transition x-cloak class="ml-8 text-sm space-y-1">
            <li>
                <a  style="text-decoration: none" href="{{ route('forms.index') }}"
                class="block px-4 py-2 hover:bg-gray-700 text-white hover:text-white rounded"
                :class="{ 'liactive': '{{ Route::currentRouteName() == 'forms.index' }}' }">
                <i class="ml-2 fas fa-file-alt mr-2"></i> {{ __('messages.Forms', [], session()->get('applocale')) }}
                </a>
            </li>
            <li>
                <a  style="text-decoration: none" href="{{ route('factors.index') }}"
                class="block px-4 py-2 hover:bg-gray-700 text-white hover:text-white rounded"
                :class="{ 'liactive': '{{ Route::currentRouteName() == 'factors.index' }}' }">
                <i class="ml-2 fas fa-sliders-h mr-2"></i> {{ __('messages.Factors', [], session()->get('applocale')) }}
                </a>
            </li>
            <li>
                <a   style="text-decoration: none" href="{{ route('identifiers.index') }}"
                class="block px-4 py-2 hover:bg-gray-700 text-white hover:text-white rounded"
                :class="{ 'liactive': '{{ Route::currentRouteName() == 'identifiers.index' }}' }">
                <i class="ml-2 fas fa-tags mr-2"></i> {{ __('messages.Identifiers', [], session()->get('applocale')) }}
                </a>
            </li>
        </ul>



        <a href="{{ route('entries.index') }}" class="flex nodec full-width items-center hover:bg-gray-700 hover:text-white ">
            <li class="h-12 px-6 py-2 hover:bg-gray-700 flex items-center"
                :class="{ 'liactive': '{{ Route::currentRouteName() == 'entries.index' }}' }">
                <i class="fas fa-journal-whills mr-3" :class="isSidebarOpen ? 'block' : 'hidden'"></i>
                <p class="ml-4" :class="isSidebarOpen ? 'block' : 'hidden'">{{ __('Entries', [], session()->get('applocale'))}}</p>
            </li>
        </a>
        @endif
        <!--<li class="h-12 px-6 py-2 hover:bg-gray-700 flex items-center">
            <a href="" class="flex nodec items-center">
                <i class="fas fa-comments mr-3" :class="isSidebarOpen ? 'block' : 'hidden'"></i>
                <p class="ml-4" :class="isSidebarOpen ? 'block' : 'hidden'">Forum</p>
            </a>
        </li>
        <li class="h-12 px-6 py-2 hover:bg-gray-700 flex items-center">
            <a href="" class="flex nodec items-center">
                <i class="fas fa-envelope mr-3" :class="isSidebarOpen ? 'block' : 'hidden'"></i>
                <p class="ml-4" :class="isSidebarOpen ? 'block' : 'hidden'">Messages</p>
            </a>
        </li>-->
    </ul>
</aside>