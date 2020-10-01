<div>
<main wire:init="loadResources" class="flex flex-wrap w-full pt-12">
    <div wire:loading class="w-full flex justify-center">
        <div wire:loading class="animate-ping h-12 w-12 text-gray-700 hover:text-gray-500 focus:outline-none 
            focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 
            transition ease-in-out duration-150">
            <img src="{{ asset('img/bird-icon-round.png') }}" />
        </div>
    </div>
    
    @foreach (collect($poems)->take($perPage) as $poem)
    <article class="pb-32 px-4 w-full lg:w-1/2 xl:w-1/3">
        @include('project.poems._single', ['poem' => $poem])
    </article> 
    @endforeach

    @if ($readyToLoad)
        @if ($poems->count() > $perPage)
        <div class="w-full">
            <livewire:project.poem.load-more wire:key="2" :poemIds="$poems->pluck('id')" :perPage="$perPage" :page="2" />
        </div>  
        @endif
    @endif 
</main>

<footer class="max-w-lg mx-auto mb-10">
    @if ($readyToLoad)
    <header class="mb-10">
        @if ($poems->count() > 0)
            <span class="text-4xl text-gray-400">{{ $poems->count() }} </span>
            @if ($poems->count() === 1) 
                Manuscript
            @else 
                Manuscripts 
            @endif
        @else 
            No Manuscripts matched your curation
        @endif
    </header>
    @endif

    @if ($filterQuery)
    <div class="block flex-1 mb-16">
        <x-heroicon-o-search class="w-8 text-gray-500 inline-block align-middle" />
        <p class="text-black text-3xl inline-block align-middle">
            {{ $filterQuery }}
        </p>
    </div>
    @endif

    @if(optional($filterCategoryBirds)->count())
        <section class="mb-10">
            <x-project.audit.dickinsons-birds :dickinsonsBirds="$filterCategoryBirds" />
        </section>
    @endif 

    @if ($filterFilterables && $filterFilterables->count())
        <h1 class="text-gray-800 mb-4">
            Manuscript Attributes filtered for--
        </h1>

        @foreach ($filterFilterables as $filterable)
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
                                <button wire:click="$emitTo('project.filterable-attribute', 'activeAttributeRemoved', '{{ $filterableAttribute->id }}', '{{ $value }}' )">
                                    <x-heroicon-o-x-circle class="w-4" />
                                </button>
                            </span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @endif

    @if (optional($filterFilterables)->count() || $filterQuery || optional($filterCategoryBirds)->count())
        <footer class="justify-center">
            <button wire:click="resetAllFilters" class="bg-green-700 border-2 text-white py-2 px-4 border-green-600 shadow-2xl">
                Reset All Filters
            </button>
        </footer>
    @endif

</footer>

</div>
