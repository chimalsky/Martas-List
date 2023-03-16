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
                Transcription Text Query:
                
                <span data-action="click->archive#relayClearQuery" class="text-black inline-block py-1 px-4 cursor-pointer relative" style="background-color: #F7F5E7">
                    {{ $query }}

                    @include('project._filter_x')
                </span>
            </div>
        @endif 

        @foreach ($activeFilterables as $filterable)
            <div class="text-center mb-6">
                <header class="block mb-2">
                    {{ $filterable->title }}
                </header>

                <main class="flex flex-wrap justify-center gap-2">
                    @foreach(request()->input('filterable.' . $filterable->id) as $selectedValue)
                        <label class="text-black inline-block py-1 px-4 cursor-pointer relative"
                            style="color: #666; border: 1px solid #dfe7d7; background-color: #F7F5E7">
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

                            @include('project._filter_x')
                        </label>
                    @endforeach
                </main>
            </div>
        @endforeach 

        @if (count($activeBirds))
            <section class="p-4">
                <header class="text-2xl text-center mb-3">
                    Bird Species
                </header>

                <main class="flex flex-wrap justify-center gap-2">
                    @foreach ($activeBirds as $bird) 
                        <label class="text-black text-center inline-block py-1 px-4 cursor-pointer relative"
                            style="color: #666; border: 1px solid #dfe7d7; background-color: #F7F5E7">
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
                            @include('project._filter_x')
                        </label>
                    @endforeach
                </main>
            </section>
        @endif
    </div>

    @if ($results->count())
        <div class="block mx-auto max-w-md text-xl text-center">
            {{ $results->flatten()->count() }} Poem {{ Str::of('Manuscript')->plural($results->flatten()->count()) }} 
        </div>
    @endif
</header>

<section id="results-list px-6">
    <main class="flex flex-wrap w-full pt-12">
        @if ($results->count())
            <x-project.poem.list :poems="$results" showYear :attributeOrder="$attributeOrder" />
        @else 
            <h1 style="color: #96a9a9" class="text-2xl text-center w-full">
                No poems match your curation
            </h1>
        @endif
    </main>
</section>
