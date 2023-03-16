<header id="results-composition" class="gap-4 mt-12 px-6">
    <div data-target="archive.formFacade"">
        @if (count($activeFilterables) || count($activeBirds) || isset($query))
            <div class="text-right mb-12 flex justify-center">
                <x-hollow-button data-action="archive#clearForm">
                    Clear Curation Filters
                </x-hollow-button>
            </div>
        @endif 

        @if (isset($query))
            <div class="text-center mb-6">
                Bird Species Query:
                
                <span data-action="click->archive#relayClearQuery" class="text-black inline-block py-1 px-4 cursor-pointer relative" style="background-color: #F7F5E7">
                    {{ $query }}

                    <span class="absolute top-0 right-0 pr-1 pt-1 text-xs text-gray-500">
                        X
                    </span>
                </span>
            </div>
        @endif 

        @foreach ($activeFilterables as $filterable)
            <div class="text-center mb-6">
                <header class="block">
                    {{ $filterable->title }}
                </header>

                <main class="flex flex-wrap justify-center space-x-2 space-y-1">
                    @foreach(request()->input('filterable.' . $filterable->id) as $selectedValue)
                        <label class="text-black inline-block py-1 px-4 cursor-pointer relative" style="background-color: #F7F5E7">
                            <input data-action="change->archive#relayAction" type="checkbox"
                                name="filterable[{{ $filterable->id }}][]"
                                value="{{ $selectedValue }}"
                                class="hidden"
                                checked
                                autocomplete="off" 
                                    />
                            <span class="pl-2">
                                {{ $selectedValue }}
                            </span>
                            <span class="absolute top-0 right-0 pr-1 pt-1 text-xs text-gray-500">
                                X
                            </span>
                        </label>
                    @endforeach
                </main>
            </div>
        @endforeach 

        @if (isset($century))
            <header class="text-center mb-2" style="color: #999999">
                @switch ($century)
                    @case(null)
                        null city
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
            </header>
        @endif

        @if (isset($seasons) && count($seasons))
            <div class="text-center mb-6">
                <main class="flex flex-wrap justify-center space-x-2 space-y-1">
                    @foreach ($seasons as $season)
                        <label class="text-black inline-block py-1 px-4 cursor-pointer relative" style="background-color: #F7F5E7">
                            <input data-action="change->archive#relayAction" type="checkbox"
                                name="seasons[]"
                                value="{{ $season }}"
                                class="hidden"
                                checked
                                autocomplete="off" 
                                    />
                            <span class="pl-2">
                                {{ Str::title($season) }}
                            </span>
                            <span class="absolute top-0 right-0 pr-1 pt-1 text-xs text-gray-500">
                                X
                            </span>
                        </label>
                    @endforeach
                </main>
            </div>
        @endif

        @if (isset($months) && count($months))
            <div class="text-center mb-6">
                <main class="flex flex-wrap justify-center space-x-2 space-y-1">
                    @foreach ($months as $month)
                        <label class="text-black inline-block py-1 px-4 cursor-pointer relative" style="background-color: #F7F5E7">
                            <input data-action="change->archive#relayAction" type="checkbox"
                                name="months[]"
                                value="{{ $month }}"
                                class="hidden"
                                checked
                                autocomplete="off" 
                                    />
                            <span class="pl-2">
                                {{ Str::title($month) }}
                            </span>
                            <span class="absolute top-0 right-0 pr-1 pt-1 text-xs text-gray-500">
                                X
                            </span>
                        </label>
                    @endforeach
                </main>
            </div>
        @endif

        @if (count($activeBirds))
            <section class="p-4">
                <header class="text-2xl text-center">
                    Dickinson's Bird List
                </header>

                <main class="flex flex-wrap justify-center space-x-2 space-y-1">
                    @foreach ($activeBirds as $bird) 
                        <label class="text-black text-center inline-block py-6 px-4 cursor-pointer relative" style="background-color: #F7F5E7">
                            <input data-action="change->archive#relayAction" type="checkbox"
                                name="filterableBird[{{ $bird->id }}][]"
                                value="{{ $bird->id }}"
                                class="hidden"
                                checked
                                autocomplete="off" 
                                    />
                            <span class="pl-2">
                                {{ $bird->name }}
                            </span>
                            <span class="absolute top-0 right-0 pr-1 pt-1 text-xs text-gray-500">
                                <img src="/img/x-box.png" />
                            </span>
                        </label>
                    @endforeach
                </main>
            </section>
        @endif
    </div>

    @if ($results->count())
        <div class="block mx-auto max-w-md text-xl text-center">
            {{ $results->total() }} {{ Str::of('Bird')->plural($results->flatten()->count()) }}
        </div>
    @endif
</header>

<section id="results-list" class="px-6">
    <main class="w-full pt-12">
        @if ($results->count())
            <div data-controller="pagination">
                <x-project.bird.list :birds="$results" />

                @if ($results->hasMorePages())
                    <a data-pagination-target="nextPageLink" href="{{ $results->withQueryString()->nextPageUrl() }}" id="next-link" class="invisible">
                        Load More
                    </a>
                @endif
            </div>
        @else 
            <h1 class="text-2xl text-center w-full">
                No Birds match your curation
            </h1>
        @endif
    </main>
</section>
