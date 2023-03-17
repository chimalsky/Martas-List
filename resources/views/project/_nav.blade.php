<span x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false" class="relative inline-block text-left">
    <span class="flex-1 flex justify-between space-x-2">
        <div class="">
            <a href="/">
                <img src="{{ asset('img/bird-icon.png') }}" class="h-10 w-10 mb-1" />
            </a>

            <button @click="open = !open" type="button" id="menu-toggle"
            class="h-8 w-8 ml-1 border border-transparent p-1 hover:border-gray-700">
                <img src="{{ asset('img/hamburger.png') }}" />
            </button>
        </div>

        <div>
            <a href="/">
                <h1 class="" style="font-family: 'IM Fell Double Pica', serif; color: #707A5E; font-size: 22pt;">
                    Dickinson's Birds
                </h1>
            </a>
            <h2 style="font-family: Josefin Sans; letter-spacing: 2.5px; color: #806f68;" class="text-sm uppercase mt-2">
                A listening machine
            </h2>
        </div>
    </span>
    <span x-show="open" 
        x-transition:enter="transition ease-out duration-300" 
        x-transition:enter-start="transform opacity-0 scale-95" 
        x-transition:enter-end="transform opacity-100 scale-100" 
        x-transition:leave="transition ease-in duration-300" 
        x-transition:leave-start="transform opacity-100 scale-100" 
        x-transition:leave-end="transform opacity-0 scale-95" 
        class="origin-top-left absolute left-0 rounded-md shadow-2xl flex-1 z-50"
        style="width: 16rem; display: none;">
        <div class="rounded-md bg-white shadow-xs">
        <div class="py-1 text-base">
            @include('project._nav-items')
        </div>
        </div>
    </span>
</span>