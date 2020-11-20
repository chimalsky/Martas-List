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

    @if(optional($activeBirdCategories)->count())
        <section class="mb-10">
            <header class="text-gray-800 mb-4">
                Bird Categories --
            </header>
            @foreach ($activeBirdCategories as $activeBirdCategory)
                <div class="border-l-4 border-red-400 pl-4 mb-2">
                    @php $birdC = \App\Project\DickinsonsBird::find($activeBirdCategory) @endphp

                    <header class="font-bold text-gray-800" x-data="{expanded: false}">
                        <span @click="expanded = !expanded">
                            {{ $birdC->name }}
                        </span>
                        <span x-show="expanded">
                            <button wire:click="$emitTo('project.bird.filter', 'activeBirdRemoved', {{ $birdC->id }})">
                                <x-heroicon-o-x-circle class="w-4" />
                            </button>
                        </span>
                    </header>
                </div>
            @endforeach
        </section>
    @endif 

    @if ($activeChronoScope == 'seasons')
        @if (optional($activeSeasons)->count())
            @php
                $activeSeasonsSorted = $activeSeasons->mapWithKeys(function($s) {
                    return [ $s => App\Project\SeasonEnum::getConstant($s) ];
                })->sort()->keys();
            @endphp 

            <section class="mb-10">
                <header class="text-gray-800 mb-4">
                    Active Seasons--
                </header>
                @foreach ($activeSeasonsSorted as $activeSeason)
                    <div class="pl-4 mb-2">
                        <header class="font-bold text-gray-800" x-data="{expanded: false}">
                            <span @click="expanded = !expanded">
                                {{ Str::title($activeSeason)  }}
                            </span>
                            <span x-show="expanded">
                                <button wire:click="$emitTo('project.bird.filter', 'activeSeasonRemoved', '{{ $activeSeason }}')">
                                    <x-heroicon-o-x-circle class="w-4" />
                                </button>
                            </span>
                        </header>
                    </div>
                @endforeach
            </section>
        @endif
    @endif 

    @if ($activeChronoScope == 'months')
        @if(optional($activeMonths)->count())
            @php
                $activeMonthsSorted = $activeMonths->mapWithKeys(function($m) {
                    return [ $m => App\Project\MonthEnum::getConstant($m) ];
                })->sort()->keys();
            @endphp 
            <section class="mb-10">
                <header class="text-gray-800 mb-4">
                    Active Months--
                </header>

                @foreach ($activeMonthsSorted as $activeMonth)
                    <div class="pl-4 mb-2">
                        <header class="font-bold text-gray-800" x-data="{expanded: false}">
                            <span @click="expanded = !expanded">
                                {{ Str::title($activeMonth) }}
                            </span>
                            <span x-show="expanded">
                                <button wire:click="$emitTo('project.bird.filter', 'activeMonthRemoved', '{{ $activeMonth }}')">
                                    <x-heroicon-o-x-circle class="w-4" />
                                </button>
                            </span>
                        </header>
                    </div>
                @endforeach
            </section>
        @endif 
    @endif
</div>
