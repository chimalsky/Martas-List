
<main x-data="{chronoScope: '{{ $activeChronoScope }}'}" class="grid grid-cols-2">
    <aside class="col-span-1 text-lg">
        <h1 class="mb-2 text-xl">
            Century
        </h1>
        <label class="mb-4 pr-4 block">
            <input type="radio" value="null"
                wire:model="activeChrono" wire:click="chronoClicked"
                /> 
            <span class="mr-4 cursor-pointer">
                All 19th, 20th, & 21st centuries
            </span>
        </label>
        @foreach (collect([19,20,21]) as $century)
            <label class="mb-4 pr-4 block">
                <input type="radio" name="order" class="" value="{{ $century }}" 
                    wire:model="activeChrono" wire:click="chronoClicked"
                    /> 
                <span class="mr-4 cursor-pointer">
                    @if ($loop->index == 2)
                        {{ $century }}th.
                    @else
                        {{ $century }}st.
                    @endif
                </span>
            </label>
        @endforeach

        <section class="mt-4">
            <div>
                @switch ($activeChrono)
                    @case(null)
                        <span class="italic">
                            19th, 20th, & 21st centuries
                        </span> 
                        @break
                    @case(19)
                        H. L. Clark’s 
                        <span class="italic">
                            The Birds of Amherst & Vicinity, including nearly the whole of Hampshire County 
                        </span> (1887)
                        @break 
                    @case(20)
                        Aaron Clark Bagg and Samuel Atkins Eliot Jr.’s 
                        <span class="italic">
                            Birds of the Connecticut Valley in Massachusetts
                        </span> (1937)
                        @break 
                    @case(21)
                        <span class="italic">
                            Mass Audubon | Birds of Massachusetts
                        </span> (2020)
                        @break
                @endswitch
            </div>
        </section>
    </aside>

    <main class="col-span-1">
        <header class="mb-4">
            <button wire:click="$set('activeChronoScope','seasons')"
                :class="{ 'border-b border-gray-700': (chronoScope == 'seasons') }"
                class="px-3 pb-1 font-medium text-sm leading-5 rounded-md">
                Seasons
            </button>
            <button wire:click="$set('activeChronoScope','months')"
                :class="{ 'border-b border-gray-700': (chronoScope == 'months') }"
                class="px-3 pb-1 font-medium text-sm leading-5 rounded-md">
                Months
            </button>
        </header>

        <section x-show="chronoScope == 'seasons'" class="col-span-1 col-start-1">
            @php 
                $seasons = \App\Project\SeasonEnum::getConstants();
            @endphp 
            <section class="col-span-1">
                @foreach ($seasons as $key => $value)
                    <label class="mb-2 block container relative text-base cursor-pointer hover:underline">
                        <input wire:click="updateSeason('{{ $key }}')"
                            type="checkbox"
                            class=""
                            autocomplete="off" 
                            @if ($activeSeasons->contains($key))
                                checked 
                            @endif/>
                        <span class="checkmark border-2 border-gray-500"></span>

                        <span class="pl-6">
                            {{ Str::title($key) }}
                        </span>
                    </label> 
                @endforeach
            </section>
        </section>

        <section x-show="chronoScope == 'months'" class="col-span-1 col-start-2">
            
            <div class="grid grid-cols-2">
                @php
                    $months = \App\Project\MonthEnum::getConstants();
                @endphp

                <div class="col-span-1">
                    @foreach (collect($months)->take(6) as $key => $value)
                        <label class="mb-2 block container relative text-base cursor-pointer hover:underline">
                            <input wire:click="updateMonth('{{ $key }}')"
                                type="checkbox"
                                class=""
                                autocomplete="off" 
                                @if ($activeMonths->contains($key))
                                    checked 
                                @endif />
                            <span class="checkmark border-2 border-gray-500"></span>

                            <span class="pl-6">
                                {{ Str::title($key) }}
                            </span>
                        </label> 
                    @endforeach
                </div>
                <div class="col-span-1">
                    @foreach (collect($months)->splice(6)->take(6) as $key => $value)
                        <label class="mb-2 block container relative text-base cursor-pointer hover:underline">
                            <input wire:click="updateMonth('{{ $key }}')"
                                type="checkbox"
                                class="""
                                autocomplete="off" 
                                @if ($activeMonths->contains($key))
                                    checked 
                                @endif />
                                
                            <span class="checkmark border-2 border-gray-500"></span>

                            <span class="pl-6">
                                {{ Str::title($key) }}
                            </span>
                        </label> 
                    @endforeach
                </div>
            </div>
        </section>
    </main>
</main>