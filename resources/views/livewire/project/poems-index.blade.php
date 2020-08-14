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
    </aside>

    <section class="flex flex-wrap w-full pt-12">
        @if ($this->poems->count())
            <main class="flex flex-wrap w-full pt-12">
                @foreach ($this->poemsPaginated as $poem)
                    <article class="pb-32 px-4 w-full lg:w-1/2 xl:w-1/3">
                        @include('project.poems._single', ['poem' => $poem, 'query' => $query])
                    </article> 
                @endforeach
            </main>

            @if ($this->poemsPaginated->hasMorePages())
                <button>
                    Load More -- {{ $this->poemsPaginated->total() - $this->poemsPaginated->count() }} Manuscripts Remaining
                </button>
            @endif
        @endif
        

        <div class="items-center justify-center w-full text-gray-700 font-semibold">
            <section class="max-w-2xl mx-auto">
                @unless ($this->isCurating)
                @else
                    @unless ($query || $activeFilterables)
                        <p class="block text-xl mb-12 text-gray-800">
                            Search and Curate Manuscripts
                        </p>
                    @else
                        @unless ($this->poems->count())
                            <p class="block text-xl mb-12 text-left text-gray-800">
                                No poems match your curation
                            </p>
                        @endunless
                    @endunless
                @endunless

                @if ($query)
                    <p class="block flex-1 mb-16 text-black text-3xl text-left">
                        <span class="text-gray-600">transcription text query--</span> 
                        <br/>
                        {{ $query }}
                    </p>
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
