<div x-data="{open: false}">

<section class="w-full">
    <section x-show="open" @click.away="open = false">
        @include('project.poems._filter')
    </section>
</section>

<section class="flex justify between">
    @if ($this->isCurating)
        <aside class="max-w-xs">
            <button @click="open = !open" class="bg-orange-700 rounded-md text-white p-2 px-6 italic text-lg mb-6">
                Curate
            </button>

            <input wire:model.debounce.200ms="query" placeholder="search by poem text"
                class="block mb-4 border-4 border-gray-700 rounded-full pl-4 p-2 placeholder-gray-800" /> 
        </aside>
    @endif

    <section class="flex flex-wrap w-full">
        @if ($poems->count())
            @foreach ($poems as $poem)
                <article class="pb-32 px-4 cursor-pointer w-1/3">
                    @include('project.poems._single', ['poem' => $poem, 'query' => $query])
                </article> 
            @endforeach

            <nav class="w-full">
                {{ $poems->links() }}
            </nav>
        @else 
            <div class="items-center justify-center w-full text-gray-500 font-semibold">
                <section class="max-w-2xl mx-auto">
                    @unless ($this->isCurating)
                        <p class="block text-2xl block mb-4 text-left">
                            Explore Dickinson's Bird Manuscripts by text...
                        </p>

                        <input wire:model.debounce.500ms="query"
                            class="block mb-16 border-4 border-gray-600 text-gray-800 rounded-full pl-4 p-2 placeholder-gray-800 mx-auto w-full" /> 

                        <p class="block text-2xl text-left mb-4">
                            Or curate Manuscripts by a variety of attributes.
                        </p>

                        <button @click="open = !open" class="bg-orange-700 rounded-md text-white p-2 px-6 italic text-lg mb-6 float-left">
                            Curate
                        </button>
                    @else
                        @unless ($query || $activeFilterables)
                            <p class="block text-2xl mb-12 text-gray-800">
                                Search and Curate Manuscripts
                            </p>
                        @else 
                            <p class="block text-xl mb-12 text-left text-gray-800">
                                No poems match your curation
                            </p>
                        @endunless
                    @endunless

                    @if ($query)
                        <p class="block flex-1 mb-16 text-black text-3xl text-left">
                            <span class="text-gray-500">transcription text query--</span> 
                            <br/>
                            {{ $query }}
                        </p>
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
                </section>
            </div>
        @endif
    </section>
</section>

@if ($this->isCurating)
    <footer class="flex fixed w-full bottom-0 mb-4 justify-center">
        <button wire:click="resetAll" class="bg-green-500 border-2 text-white py-2 px-4 border-green-600 shadow-2xl">
            Reset All Filters
        </button>
    </footer>
@endif

</div>
