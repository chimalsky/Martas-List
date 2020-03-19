<span x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false" class="relative inline-block text-left">
    <span class="flex-1">
        <span class="rounded-md shadow-sm flex items-center">
            <button @click="open = !open" type="button" 
            class="h-10 w-10 bg-indigo-400 text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150">
                <img src="{{ asset('img/bird-icon.png') }}" />
            </button>
            
            <h1 class="pl-2">
                @isset ($title)
                    <span class=text-2xl font-black text-gray-600">
                        {{ $title }}
                    </span>
                @else
                    Dickinson's Birds
                @endisset 
            </h1>
        </span>
    </span>
    <span x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" 
    class="origin-top-left absolute left-0 w-56 rounded-md shadow-2xl flex-1">
        <div class="rounded-md bg-white shadow-xs">
        <div class="py-1">
            <a href="@route('project.index')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Home
            </a>
            <a href="@route('project.about')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                About
            </a>
            <a href="@route('project.poems.index')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Poem Archive
            </a>
            <a href="@route('project.birds.index')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Bird Archive
            </a>
            <a href="@route('project.poems.index')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Search
            </a>
        </div>
        </div>
    </span>
</span>