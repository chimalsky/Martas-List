<div>
<main wire:init="loadPoems" class="flex flex-wrap w-full pt-12">
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
        <livewire:project.poem.load-more :poems="$poems" :perPage="$perPage" :page="2" />  
        @endif
    @endif 
</main>

<footer class="max-w-lg mx-auto">
    @if ($readyToLoad)
    <header class="mb-10">
        @if ($poems->count() > $perPage)
            <span class="text-4xl text-gray-400">{{ $poems->count() }} </span>
            @if ($poems->count() === 1) 
                Manuscript -- how unique!
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

    @if($filterCategoryBirds && $filterCategoryBirds->count())
        <section class="mb-10">
            <header class="text-gray-800 mb-4">
                Manuscripts mentioning birds--
            </header>
            @foreach ($filterCategoryBirds as $birdC)
                <div class="border-l-4 border-red-400 pl-4 mb-2">
                    <header class="font-bold text-gray-800" x-data="{expanded: false}">
                        <span @click="expanded = !expanded">
                            {{ $birdC->name }}
                        </span>
                        <span x-show="expanded">
                            <button>
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

</footer>

</div>
