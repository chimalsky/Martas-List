<div x-data="{open: false}">

<section class="w-full">
    <section x-show="open" @click.away="open = false">
        @include('project.poems._filter')
    </section>
</section>

<section class="flex justify between">
    

    <section class="flex flex-wrap w-full pt-12">
        <livewire:project.poems-list :perPage="18" :page="1" />

        <div id="js-show-at-end-of-list" class="items-center justify-center w-full text-gray-700 font-semibold mt-10">
            <section class="max-w-2xl mx-auto">

                <header class="mb-10">
                    @if ($this->poemsPaginated->total())
                        <span class="text-4xl text-gray-400">{{ $this->poemsPaginated->total() }} </span>
                        @if ($this->poemsPaginated->total() === 1) 
                            Manuscript -- how unique!
                        @else 
                            Manuscripts 
                        @endif
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

                                <header class="font-bold text-gray-800" x-data="{expanded: false}">
                                    <span @click="expanded = !expanded">
                                        {{ $birdC->name }}
                                    </span>
                                    <span x-show="expanded">
                                        <button wire:click="filterByBird('{{$activeBirdCategory}}')">
                                            <x-heroicon-o-x-circle class="w-4" />
                                        </button>
                                    </span>
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
                        @php
                            $activeValues = $filterable['activeValues'];
                            $filterableAttribute = \App\ResourceAttribute::find($filterable['id']);
                        @endphp
                        <div class="block mb-5 text-xl">
                            <p class="text-gray-500">
                                {{ $filterableAttribute->name }} that are within--
                            </p>

                            <ul>
                                @foreach($activeValues as $value)
                                    <li class="text-black" x-data="{expanded: false}">
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
