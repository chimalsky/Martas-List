<div x-data="{open: false}" class="mt-40">

    <x-project.modal>
        @include('livewire.project.poem._filter')
    </x-project.modal>


    <button x-show="!open" @click="open = !open" 
        style="background: #B45F06"
        class="rounded-md text-white p-2 px-6 italic text-xl font-bold font-serif mb-6">
        Curate
    </button>

    <input wire:model.debounce.200msx`="query" placeholder="search by keyword..."
        class="block mb-4 border-4 border-gray-700 text-black rounded-full pl-4 p-2 placeholder-gray-800" />

    <section class="mb-10">
        @if ($renderCount)
            <span class="text-2xl text-gray-800">{{ $renderCount }} </span>
            @if ($renderCount === 1) 
                Manuscript
            @else 
                Manuscripts 
            @endif
        @endif
    </section>

    @if(optional($activeBirdCategories)->count())
    <section class="mb-10">
        <header class="text-gray-800 mb-4">
            Manuscripts mentioning birds--
        </header>
        @foreach ($activeBirdCategories as $activeBirdCategory)
            <div class="border-l-4 border-red-400 pl-4 mb-2">
                @php $birdC = \App\Project\DickinsonsBird::find($activeBirdCategory) @endphp

                <header class="font-bold text-gray-800" x-data="{expanded: false}">
                    <span @click="expanded = !expanded">
                        {{ $birdC->name }}
                    </span>
                    <span x-show="expanded">
                        <button wire:click="$emitTo('project.poem.filter', 'activeBirdRemoved', {{ $birdC->id }})">
                            <x-heroicon-o-x-circle class="w-4" />
                        </button>
                    </span>
                </header>
            </div>
        @endforeach
    </section>
    @endif 

    @foreach ($activeFilterables as $filterable)
    <div class="block mb-5">
        <p class="">
            {{ \App\ResourceAttribute::find($filterable['id'])->name }}
        </p>

        <ul>
            @foreach($filterable['activeValues'] as $value)
                @php 
                    $filterableId = $filterable['id'];
                @endphp
                <li class="text-black pl-2" x-data="{expanded: false}">
                    <span @click="expanded = !expanded">
                        {{ $value }}
                    </span>

                    <span x-show="expanded">
                        <button wire:click="$emitTo('project.filterable-attribute', 'activeAttributeRemoved', '{{ $filterableId }}', '{{ $value }}' )">
                            <x-heroicon-o-x-circle class="w-4" />
                        </button>
                    </span>
                </li>
            @endforeach
        </ul>
    </div>
    @endforeach

</div>
