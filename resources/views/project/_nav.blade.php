<span x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false" class="relative inline-block text-left">
    <span class="flex-1">
        <span class="rounded-md flex items-center">
            <button @click="open = !open" type="button" id="menu-toggle"
            class="h-12 w-12 text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150">
                <img src="{{ asset('img/hamburger_hover_combo.png') }}" />
            </button>
            
            <h1 class="ml-1" style="font-family: 'IM Fell Double Pica', serif; color: #707A5E; font-size: 22pt;">
                Dickinson's Birds
            </h1>
        </span>
        <h2 class="block ml-3 font-serif italic" style="font-size: 19.5pt;">
            A Public Listening Project
        </h2>
    </span>
    <span x-show="open" 
        x-transition:enter="transition ease-out duration-300" 
        x-transition:enter-start="transform opacity-0 scale-95" 
        x-transition:enter-end="transform opacity-100 scale-100" 
        x-transition:leave="transition ease-in duration-300" 
        x-transition:leave-start="transform opacity-100 scale-100" 
        x-transition:leave-end="transform opacity-0 scale-95" 
        class="origin-top-left absolute left-0 rounded-md shadow-2xl flex-1 z-50"
        style="width: 24rem">
        <div class="rounded-md bg-white shadow-xs">
        <div class="py-1">
            @include('project._nav-items')
        </div>
        </div>
    </span>
</span>