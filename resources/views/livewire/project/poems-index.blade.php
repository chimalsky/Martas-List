<div x-data="{open: false}">

<section class="w-full">
    <section x-show="open" @click.away="open = false">
        @include('project.poems._filter')
    </section>
</section>

<section class="flex justify between">
    <aside class="hidden md:block sticky max-w-xs h-full top-0 pt-16">
        <button x-show="!open" @click="open = !open; scrollToFilter();" 
            class="bg-orange-700 rounded-md text-white p-2 px-6 italic text-xl font-bold font-serif mb-6">
            Curate
        </button>

        <script>
            function scrollToFilter() {
                setTimeout(function() {
                    console.log(document.querySelector('#js-poems-filter').offsetTop)
                    window.scrollTo({ 
                        left: 0, 
                        top: document.querySelector('#js-poems-filter').offsetTop, 
                        behavior: 'smooth'
                    });
                }, 150)
            }
        </script>

        <input wire:model.debounce.200ms="query" placeholder="search by poem text"
            class="block mb-4 border-4 border-gray-700 text-black rounded-full pl-4 p-2 placeholder-gray-800" />
            
        @foreach ($activeFilterables as $filterable)
            <div class="block mb-5">
                <p class="">
                    {{ \App\ResourceAttribute::find($filterable['id'])->name }}
                </p>

                <ul>
                    @foreach($filterable['activeValues'] as $value)
                        <li class="text-black pl-2">
                            {{ $value }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach

        @foreach ($activeBirdCategories as $activeBirdCategory)
            <div class="border-l-4 border-red-400 pl-4 mb-2">
                @php $birdC = \App\ResourceCategory::find($activeBirdCategory) @endphp

                <header class="font-bold text-gray-800">
                    {{ $birdC->name }}
                </header>
            </div>
        @endforeach
    </aside>

    <section class="flex flex-wrap w-full pt-12">
        <livewire:project.poems-list :perPage="18" :page="1" />

        <div class="items-center justify-center w-full text-gray-700 font-semibold">
            <section class="max-w-2xl mx-auto">

                <header class="mb-10">
                    @if ($this->poemsPaginated->total())
                        <span class="text-4xl text-gray-400">{{ $this->poemsPaginated->total() }} </span>
                        Manuscripts
                    @else 
                        No Manuscripts matched your curation
                    @endif
                </header>

                @if ($query)
                    <div class="block flex-1 mb-16">
                        <x-heroicon-o-search class="w-8 text-gray-500 inline-block align-middle" />
                        <p class="text-black text-3xl inline-block align-middle">
                            {{ $query }}
                        </p>
                    </div>
                @endif

                @if($activeBirdCategories && $activeBirdCategories->count())
                    <section class="mb-10">
                        <header class="text-gray-800 mb-4">
                            Manuscripts mentioning birds--
                        </header>
                        @foreach ($activeBirdCategories as $activeBirdCategory)
                            <div class="border-l-4 border-red-400 pl-4 mb-2">
                                @php $birdC = \App\ResourceCategory::find($activeBirdCategory) @endphp

                                <header class="font-bold text-gray-800">
                                    {{ $birdC->name }}
                                </header>

                                @foreach( $birdC->resources as $resource )
                                    {{ $resource->name }} @unless($loop->last),@endunless
                                @endforeach
                            </div>
                        @endforeach
                    </section>
                @endif 

                @if ($activeFilterables->count())
                    <h1 class="text-gray-800 mb-4">
                        Manuscript Attributes filtered for--
                    </h1>
                    @foreach ($activeFilterables as $filterable)
                        <div class="block mb-5 text-xl">
                            <p class="text-gray-500">
                                {{ \App\ResourceAttribute::find($filterable['id'])->name }} that are within--
                            </p>

                            <ul>
                                @foreach($filterable['activeValues'] as $value)
                                    <li class="text-black">
                                        {{ $value }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                @endif


                @if ($this->isCurating)
                    <footer class="justify-center">
                        <button wire:click="resetAll" class="bg-green-700 border-2 text-white py-2 px-4 border-green-600 shadow-2xl">
                            Reset All Filters
                        </button>
                    </footer>
                @endif
            </section>
        </div>
    </section>
</section>

</div>
