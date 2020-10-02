<div id="js-poems-filter" class="relative w-full bg-white shadow-lg">
    <header class="block">
        <h1 style="background: #B45F06" class="font-serif text-2xl text-white font-garamond font-thin p-3 italic shadow-xl flex justify-between">
            <span class="text-center w-full pl-6">
                Sort By--
            </span>

            <button class="float-right" @click="open = false">
                <x-heroicon-o-x class="w-8" />
            </button>
        </h1>
    </header>

    <main class="w-full flex flex-wrap">
        <div class="p-4 w-4/12">
            <x-project.filter.dickinsons-birds :dickinsonsBirds="$dickinsonsBirds" :activeBirdCategories="$activeBirdCategories" />
        </div>
        <div class="p-4 w-5/12">
            <x-project.filter.presence :activeSeasons="$activeSeasons" :activeMonths="$activeMonths" :activeChrono="$activeChrono" />
        </div>
        <div class="p-4 w-3/12">
            <header class="text-xl mb-2">
                Current Conservation Status
            </header>
            <main class="flex flex-wrap p-3 bg-yellow-100">
                @php
                    $conservationStates = [
                        'Low concern' => 'low concern',
                        'Extinct' => 'extinct',
                        'Watch' => 'watch',
                        'Unknown' => 'unknown',
                        'Steep-decline' => 'steep decline'
                    ];
                @endphp 

                @foreach ($conservationStates as $key => $value)
                    <label class="mb-2 w-1/2 container relative text-base cursor-pointer hover:underline">
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
    </main>

</div>