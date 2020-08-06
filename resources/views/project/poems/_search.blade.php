<div class="w-full">
    <p class="block text-xl block mb-4 text-left">
        Explore Dickinson's Bird Manuscripts by text...
    </p>

    <input wire:model.debounce.500ms="query"
        class="block mb-16 border-4 border-gray-600 text-gray-800 rounded-full pl-4 p-2 placeholder-gray-800 mx-auto w-full" /> 

    <p class="block text-xl text-left mb-4">
        Or curate Manuscripts by a variety of attributes.
    </p>

    <button @click="open = !open" class="bg-orange-700 rounded-md text-white p-2 px-6 italic text-lg mb-6 float-left">
        Curate
    </button>
</div>