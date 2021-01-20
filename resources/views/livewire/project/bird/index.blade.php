<div>
<div wire:loading class="w-full flex justify-center">
    <div wire:loading class="animate-ping h-12 w-12 text-gray-700 hover:text-gray-500 focus:outline-none 
        focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 
        transition ease-in-out duration-150 fixed bottom-0 mb-8">
        <img src="{{ asset('img/bird-icon-round.png') }}" />
    </div>
</div>

<main wire:init="loadResources" class="flex flex-wrap w-full pt-12">
    <header class="w-full grid grid-cols-3 gap-2 mb-10">
        <div class="text-black rounded col-span-1">
            @if ($this->filterChrono && $this->filterChrono != 'null')
                <header class="p-2 m-1 text-center" style="background-color: #F7F5E7">
                    @switch ($this->filterChrono)
                        @case(19)
                            H. L. Clark, (1887)
                            @break 
                        @case(20)
                            Aaron Clark Bagg and Samuel Atkins Eliot Jr., (1937)
                            @break 
                        @case(21)
                            Mass Audubon - Birds of Massachusetts, (2020)
                            @break
                    @endswitch
                </header>
            @endif

            @php 
                $centuryText = collect([19,20])->contains($this->filterChrono)
                    ? $this->filterChrono.'th c'
                    : $this->filterChrono.'st c';
            @endphp

            @if ($filterChronoScope == 'seasons')
                @if (optional($filterSeasons)->count())
                    @php
                        $activeSeasonsSorted = $filterSeasons->mapWithKeys(function($s) {
                            return [ $s => App\Project\SeasonEnum::getConstant($s) ];
                        })->sort()->keys();
                    @endphp 

                    <section class="mb-10">
                        <div class="text-xl col-span-1">
                            <p class="text-gray-800">
                                Seasons in Amhrest {{ $centuryText }}
                            </p>

                            <ul>
                                @foreach($activeSeasonsSorted as $activeSeason)
                                    <li class="text-black inline-block py-1 px-4" style="background-color: #F7F5E7">
                                        {{ Str::title($activeSeason) }}

                                        <button wire:click="$emitTo('project.bird.filter', 'activeSeasonRemoved', '{{ $activeSeason }}')">
                                            <x-heroicon-o-x-circle class="w-4" />
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </section>
                @endif
            @endif 

            @if ($filterChronoScope == 'months')
                @if(optional($filterMonths)->count())
                    @php
                        $activeMonthsSorted = $filterMonths->mapWithKeys(function($m) {
                            return [ $m => App\Project\MonthEnum::getConstant($m) ];
                        })->sort()->keys();
                    @endphp 
                    <section class="mb-10">
                        <header class="text-gray-800">
                            Months in Amhrest
                        </header>
                        
                        <ul>
                            @foreach ($activeMonthsSorted as $activeMonth)
                                <li class="text-black inline-block py-1 px-4" style="background-color: #F7F5E7">
                                    {{ Str::title($activeMonth) }}

                                    <button wire:click="$emitTo('project.bird.filter', 'activeMonthRemoved', '{{ $activeMonth }}')">
                                        <x-heroicon-o-x-circle class="w-4" />
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endif 
            @endif
        </div>

        @if (optional($filterCategoryBirds)->count())
            <div class="text-xl col-span-1">
                <p class="text-gray-800">
                    Dickinson's Birds
                </p>
                <ul>
                    @foreach ($filterCategoryBirds as $birdCategory)
                        <li class="text-black inline-block py-1 px-2 m-1 bg-gray-300 rounded">
                            {{ $birdCategory->name }}

                            <button wire:click="$emitTo('project.bird.filter', 'activeBirdRemoved', {{ $birdCategory->id }})">
                                <x-heroicon-o-x-circle class="w-4" />
                            </button>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (optional($this->conservationStates)->count() || $this->threatQuery)
            <div class="text-xl col-span-1">
                <p class="text-gray-800">
                    Conservation States--
                </p>
                @if (optional($this->conservationStates)->count())
                    <ul>
                        @foreach ($this->conservationStates as $conservationState)
                            <li class="text-black inline-block py-1 px-2 m-1 rounded" style="background-color: #F7F5E7">
                                {{ $conservationState }}

                                <button wire:click="$emitTo('project.bird.filter', 'activeConservationStateRemoved', '{{ $conservationState }}')">
                                    <x-heroicon-o-x-circle class="w-4" />
                                </button>
                            </li>
                        @endforeach
                    </ul>
                @endif

                @if ($this->threatQuery)
                    <div class="text-black inline-block py-1 px-2 m-1 rounded bg-gray-300">
                        Threat Query-- <span class="font-medium">{{ $this->threatQuery }}</span>

                        <button wire:click="$emitTo('project.bird.filter', 'activeThreatQueryCleared')">
                            <x-heroicon-o-x-circle class="w-4" />
                        </button>
                    </div>
                @endif
            </div>
        @endif
    </header>
    
    @foreach (collect($birds)->take($perPage) as $bird)
    <article class="pb-32 px-4 w-full lg:w-1/2 xl:w-1/3">
        @include('project.birds._single', ['bird' => $bird])
    </article> 
    @endforeach

    @if ($readyToLoad)
        @if ($birds->count() > $perPage)
        <div class="w-full">
            <livewire:project.bird.load-more wire:key="2" :birdIds="$birds->pluck('id')" :perPage="$perPage" :page="2" />
        </div>  
        @endif
    @endif 
</main>

<footer class="max-w-lg mx-auto mb-10">
    @if ($readyToLoad)
        <header class="mb-10">
            @if ($birds->count() > 0)
                <span class="text-4xl text-gray-400">{{ $birds->count() }} </span>
                @if ($birds->count() === 1) 
                    Bird
                @else 
                    Birds 
                @endif
            @else 
                No Bird matches your curation
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
            <x-project.audit.dickinsons-birds :dickinsonsBirds="$filterCategoryBirds">
                <x-slot name="header">
                    Bird Categories within curation --
                </x-slot>
            </x-project.audit.dickinsons-birds>
        </section>
    @endif 


    @if (optional($filterFilterables)->count() || $filterQuery || optional($filterCategoryBirds)->count() || $this->threatQuery )
        <footer class="justify-center">
            <button wire:click="resetAllFilters" class="bg-green-700 border-2 text-white py-2 px-4 border-green-600 shadow-2xl">
                Reset All Filters
            </button>
        </footer>
    @endif

</footer>


</div>
