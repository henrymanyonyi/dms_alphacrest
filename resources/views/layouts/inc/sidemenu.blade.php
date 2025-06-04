<div class="flex-grow overflow-y-auto sidebar-scroll">
    <p class="px-5 py-2 text-xs text-gray-500 uppercase tracking-wider font-medium">Platform</p>

    <nav class="mb-auto">
        {{-- @if (Auth::user()->role->name == 'Admin') --}}
        <ul>


            <li class="mb-1">
                <a href="{{ route('sectors.index') }}"
                    class="flex items-center px-5 py-3 text-sm 
                {{ request()->routeIs('sectors.index') ? 'bg-accent-blue text-white' : 'hover:bg-gray-100' }}">
                    <i class="fas fa-users w-5 mr-3 text-center"></i>
                    Sectors
                </a>
            </li>

            <li class="mb-1">
                <a href="{{ route('data-segments.index') }}"
                    class="flex items-center px-5 py-3 text-sm 
                {{ request()->routeIs('data-segments.index') ? 'bg-accent-blue text-white' : 'hover:bg-gray-100' }}">
                    <i class="fas fa-briefcase w-5 mr-3 text-center"></i>
                    Segments
                </a>
            </li>

            <li class="mb-1">
                <a href="{{ route('data.index') }}"
                    class="flex items-center px-5 py-3 text-sm 
                {{ request()->routeIs('data.index') ? 'bg-accent-blue text-white' : 'hover:bg-gray-100' }}">
                    <i class="fas fa-briefcase w-5 mr-3 text-center"></i>
                    Data
                </a>
            </li>


        </ul>
        {{-- @endif --}}
    </nav>



    <!-- Add spacer to push admin section to bottom -->
    <div class="flex-grow"></div>
</div>
