<div id="js-poems-filter" class="relative w-full" style="background-color: #F7F5E7">
    <header style="background: #B45F06" class="p-3 pl-4 italic shadow-xl flex items-center text-white">
        <h1 class="font-serif text-xl font-thin mr-4">
            Curate by--
        </h1>

        <ul class="flex items-center mr-24">
            <li wire:click="$set('index', 0)" class="cursor-pointer @if($index === 0) underline @endif">
                Dickinson's Birds
            </li>
            <li wire:click="$set('index', 1)" class="ml-4 cursor-pointer @if($index === 1) underline @endif">
                Seasonal
            </li>
            <li wire:click="$set('index', 2)"  class="ml-4 cursor-pointer @if($index === 2) underline @endif">
                Conservation 
            </li>
        </ul>

        <button class="float-right" @click="open = false">
            <x-heroicon-o-x class="w-5" />
        </button>
    </header>

    <main>
        <div class="text-xs pt-4 pl-4 overflow-scroll h-full" style="max-height: 50vh;">
            <div class="@unless($index === 0)) hidden @endunless">
                <x-project.filter.dickinsons-birds :dickinsonsBirds="$dickinsonsBirds" :activeBirdCategories="$activeBirdCategories" />
            </div>

            <div class="@unless($index === 1)) hidden @endunless">
                <x-project.filter.presence :activeSeasons="$activeSeasons" 
                    :activeMonths="$activeMonths" :activeChrono="$activeChrono"
                    :activeChronoScope="$activeChronoScope" />
            </div>

            <div class="@unless($index === 2)) hidden @endunless">
                <header class="text-xl mb-2">
                    Current Conservation Status
                </header>
                <main class="grid grid-cols-2 gap-3 mb-4">
                    @php
                        $conservationStates = [
                            'Low concern' => 'low concern',
                            'Common bird in steep decline (STEEP DECLINE)' => 'Common bird in steep decline (STEEP DECLINE)',
                            'Restricted Range (WATCH)' => 'Restricted Range (WATCH)',
                            'Extinct' => 'extinct',
                            'Declining (WATCH)' => 'Declining (WATCH)',
                            'IUCN Red List (NEAR THREATENED)' => 'IUCN Red List (NEAR THREATENED)',
                            'Red watch list (WATCH)' => 'Red watch list (WATCH)',
                            'ICUN Red List (LEAST CONCERN)' => 'ICUN Red List (LEAST CONCERN)'
                        ];
                    @endphp 

                    @foreach ($conservationStates as $key => $value)
                        <label class="col-span-1 container relative text-base cursor-pointer hover:underline">
                            <input type="checkbox" wire:change="updateConservationState('{{ $value }}')"
                                class=""
                                autocomplete="off" />
                            <span class="checkmark border-2 border-gray-500"></span>

                            <span class="pl-6">
                                {{ $key }}
                            </span>
                        </label> 
                    @endforeach
                </main>

                <label>
                    Significant environmental threats 
                    <input wire:model.debounce.300ms="threatQuery" class="border border-black" />
                </label>
            </div>
        </div>
    </main>

</div>