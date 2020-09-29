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


    <section class="mb-10">
        @if ($renderCount)
            <span class="text-2xl text-gray-800">{{ $renderCount }} </span>
            @if ($renderCount === 1) 
                Bird
            @else 
                Birds 
            @endif
        @endif
    </section>

    @if(optional($activeSeasons)->count())
    <section class="mb-10">
        <header class="text-gray-800 mb-4">
            Active Seasons--
        </header>
        @foreach ($activeSeasons as $activeSeason)
            <div class="pl-4 mb-2">
                <header class="font-bold text-gray-800" x-data="{expanded: false}">
                    <span @click="expanded = !expanded">
                        {{ $activeSeason }}
                    </span>
                    <span x-show="expanded">
                        <button wire:click="$emitTo('project.poem.filter', 'activeBirdRemoved', {{ $activeSeason }})">
                            <x-heroicon-o-x-circle class="w-4" />
                        </button>
                    </span>
                </header>
            </div>
        @endforeach
    </section>
    @endif 
</div>
