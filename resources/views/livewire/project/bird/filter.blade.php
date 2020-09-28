<div x-data="{open: false}" class="mt-40">

    <x-project.modal>
        @include('livewire.project.bird._filter')
    </x-project.modal>


    <button x-show="!open" @click="open = !open" 
        style="background: #B45F06"
        class="rounded-md text-white p-2 px-6 italic text-xl font-bold font-serif mb-6">
        Curate
    </button>

    <input wire:model.debounce.200ms="query" placeholder="search by keyword..."
        class="block mb-4 border-4 border-gray-700 text-black rounded-full pl-4 p-2 placeholder-gray-800" />

</div>
