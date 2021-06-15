
<main x-data="{activeChrono: '}} $activeChrono }}', chronoScope: '{{ $activeChronoScope }}'}" class="">
    <aside class="col-span-1 text-lg">
        <h1 class="mb-2 text-xl">
            Century
        </h1>
        @foreach (collect([19,20,21]) as $century)
            <label class="mb-4 pr-4 block">
                <input type="radio" name="century" class="" value="{{ $century }}" data-action="change->form#changed" /> 
                <span class="mr-4 cursor-pointer">
                    @unless ($loop->index == 2)
                        {{ $century }}th.
                    @else
                        {{ $century }}st.
                    @endif
                </span>
            </label>
        @endforeach
    </aside>

    <main class="col-span-1">
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
                            class=""
                            data-action="change->form#changed" 
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
                                class=""
                                data-action="change->form#changed" 
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
                                class=""
                                data-action="change->form#changed" 
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