<header id="results-composition" class="gap-4 mt-12">
    <div data-target="archive.formFacade"">
        <input placeholder="search by transcription text..." name="query" type="hidden"
            class="block mb-4 border-4 border-gray-700 text-black rounded-full pl-4 p-2 placeholder-gray-800" />

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
                    Birds
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

    @if ($poems->count())
        <div class="block mx-auto max-w-md text-xl text-center">
            {{ $poems->count() }} Poems
        </div>
    @endif
</header>

<section id="results-list">
    <main class="flex flex-wrap w-full pt-12">
        @if ($poems->count())
            @foreach($poems as $year => $poemsList)
                <header style="background-color: #F7F5E7" class="text-xl mb-2 ml-6 sticky top-0 pb-2 px-2 shadow-md">
                    {{ $year }}
                </header>

                <x-project.poem.list :poems="$poemsList" />
            @endforeach
        @else 
            <h1 class="text-2xl text-center w-full">
                No Poems match your curation
            </h1>
        @endif
    </main>
</section>
