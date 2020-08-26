<span x-data="{ open: false }" @keydown.window.escape="open = false" @click.away="open = false" class="relative inline-block text-left">
    <span class="flex-1">
        <span class="rounded-md shadow-sm flex items-center">
            <button @click="open = !open" type="button" id="menu-toggle"
            class="h-12 w-12 text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150">
                <img src="{{ asset('img/bird-icon-round.png') }}" />
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
        class="origin-top-left absolute left-0 w-56 rounded-md shadow-2xl flex-1 z-50">
        <div class="rounded-md bg-white shadow-xs">
        <div class="py-1">
            <a href="@route('project.index')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Home
            </a>
            <a href="@route('project.about')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                About the Project
            </a>
            <a @click.prevent="alert('Not yet. Please call your congressperson')" href="@route('project.poems.index')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Navigation Notes
            </a>
            <a @click.prevent="alert('Not yet. Please call your congressperson')" href="@route('project.poems.index')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Introduction
            </a>
            <a href="@route('project.poems.index')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Poem Archive
            </a>
            <a href="@route('project.birds.index')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Bird Archive
            </a>
            <a @click.prevent="alert('Not yet. Please call your congressperson')" href="@route('project.poems.index')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Cultural Archive
            </a>
            <a @click.prevent="alert('Not yet. Please call your congressperson')" href="@route('project.poems.index')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Visitor's Field Notes
            </a>
            <a @click.prevent="alert('Not yet. Please call your congressperson')" href="@route('project.poems.index')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Glossary
            </a>
            <a @click.prevent="alert('Not yet. Please call your congressperson')" href="@route('project.poems.index')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Further Readings
            </a>
            <a @click.prevent="alert('Not yet. Please call your congressperson')" href="@route('project.poems.index')" class="block px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
                Colophon
            </a>
        </div>
        </div>
    </span>
</span>