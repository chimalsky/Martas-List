<header id="results-composition" class="gap-4 mt-12">
    <div data-target="archive.formFacade"">
        @if (count($activeFilterables) || count($activeBirds))
            <div class="text-right">
                <button data-action="archive#clearForm">
                    Clear Curation Filters
                </button>
            </div>
        @endif 

        @foreach ($activeFilterables as $filterable)
            <div class="text-center mb-6">
                <header class="block">
                    {{ $filterable->title }}
                </header>

                <main class="flex flex-wrap justify-center space-x-2 space-y-1">
                    @foreach(request()->input('filterable.' . $filterable->id) as $selectedValue)
                        <label class="text-black inline-block py-1 px-4 cursor-pointer" style="background-color: #F7F5E7">
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
                        </label>
                    @endforeach
                </main>
            </div>
        @endforeach 

        @if (count($activeBirds))
            <section class="bg-yellow-100 p-4">
                <header class="text-2xl text-center">
                    Bird Categories
                </header>

                <main class="flex flex-wrap justify-center space-x-2 space-y-1">
                    @foreach ($activeBirds as $bird) 
                        <label class="text-black text-center inline-block py-6 px-4 cursor-pointer" style="background-color: #F7F5E7">
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

<section id="results-list">
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
                No Poems match your curation
            </h1>
        @endif
    </main>
</section>