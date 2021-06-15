@php 
    $chronoScope = request()->query('months') 
        ? 'months'
        : 'seasons';
    $century = request()->query('century');
@endphp 

<main x-data="{century: '{{ $century }}', chronoScope: '{{ $chronoScope }}', uncheckMonths: () => { 
    document.querySelectorAll('.month').forEach((el) => {
        if (el.checked) el.checked = false
    })
}, uncheckSeasons: () => { 
    document.querySelectorAll('.season').forEach((el) => {
        if (el.checked) el.checked = false
    })
}}" class="">
    <aside class="col-span-1 text-lg">
        <h1 class="mb-2 text-xl">
            Century
        </h1>
        <div class="grid grid-cols-4 gap-x-2 text-base">
            <label class="mb-4 pr-4 col-span-1">
                <input type="radio" name="century" value="" data-action="change->form#changed" @click="century = null" 
                    @unless (request()->query('century')) checked @endif /> 
                <span class="cursor-pointer">
                    All
                </span>
            </label>
            @foreach (collect([19,20,21]) as $century)
                <label class="mb-4 pr-4 col-span-1">
                    <input type="radio" name="century" class="" value="{{ $century }}" data-action="change->form#changed" @click="century = '{{ $century }}'" /> 
                    <span class="cursor-pointer">
                        @unless ($loop->index == 2)
                            {{ $century }}th.
                        @else
                            {{ $century }}st.
                        @endif
                    </span>
                </label>
            @endforeach
        </div>
    </aside>
 
    <main x-show="century != null" class="col-span-1">
        <header class="mb-4">
            <button @click="chronoScope = 'seasons'" type="button"
                :class="{ 'border-b border-gray-700': (chronoScope == 'seasons') }"
                class="px-3 pb-1 font-medium text-sm leading-5 rounded-md">
                Seasons
            </button>
            <button @click="chronoScope = 'months'" type="button"
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
                    <label class="block cursor-pointer">
                        <input type="checkbox"
                            name="seasons[]"
                            value="{{ $key }}"
                            class="season"
                            data-action="change->form#changed" 
                            @click="uncheckMonths"
                            @if (collect(request()->input('seasons.' . $key))->contains($key))
                                checked 
                            @endif
                            autocomplete="off" 
                                />
                        <span class="pl-2">
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
                        <label class="block cursor-pointer">
                            <input type="checkbox"
                                name="months[]"
                                value="{{ $key }}"
                                class="month"
                                data-action="change->form#changed" 
                                @click="uncheckSeasons"
                                @if (collect(request()->input('months.' . $key))->contains($key))
                                    checked 
                                @endif
                                autocomplete="off" 
                                    />
                            <span class="pl-2">
                                {{ Str::title($key) }}
                            </span>
                        </label>
                    @endforeach
                </div>
                <div class="col-span-1">
                    @foreach (collect($months)->splice(6)->take(6) as $key => $value)
                        <label class="block cursor-pointer">
                            <input type="checkbox"
                                name="months[]"
                                value="{{ $key }}"
                                class="month"
                                data-action="change->form#changed" 
                                @click="uncheckSeasons"
                                @if (collect(request()->input('months.' . $key))->contains($key))
                                    checked 
                                @endif
                                autocomplete="off" 
                                    />
                            <span class="pl-2">
                                {{ Str::title($key) }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>
        </section>
    </main>
</main>