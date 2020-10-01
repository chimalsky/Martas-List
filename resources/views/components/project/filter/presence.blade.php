@php
    $filterBySeasons = optional($activeSeasons)->count();
@endphp

<main x-data="{filterBySeasons: {{ $filterBySeasons }}}">
    <nav class="mb-4">
        <button @click="filterBySeasons = 1"
            :class="{ 'bg-gray-300 text-gray-900': filterBySeasons }"
            class="px-3 py-2 font-medium text-sm leading-5 rounded-md">
            Seasons
        </button>
        <button @click="filterBySeasons = 0"
            :class="{ 'bg-gray-300 text-gray-900': !filterBySeasons }"
            class="px-3 py-2 font-medium text-sm leading-5 rounded-md">
            Months
        </button>
    </nav>

    <section x-show="filterBySeasons">
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

    <section x-show="!filterBySeasons">
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

    <footer class="mt-8">
        @foreach (collect([19,20,21]) as $century)
        <label class="mb-4 pr-4 cursor-pointer">
            <input type="radio" name="order" class="" value="{{ $century }}" 
                wire:model="activeChrono" wire:click="chronoClicked"
                /> 
            <span class="mr-4">
                @if ($loop->index == 2)
                    {{ $century }}th.
                @else
                    {{ $century }}st.
                @endif
                Century
            </span>
        </label>
        @endforeach
    </footer>
</main>