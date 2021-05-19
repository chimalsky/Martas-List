<header id="results-composition" class="gap-4 flex justify-center mt-12">
    <form data-controller="form" action="@route('project.poems.index')" method="get">
        <input placeholder="search by transcription text..." name="query" type="hidden"
            class="block mb-4 border-4 border-gray-700 text-black rounded-full pl-4 p-2 placeholder-gray-800" />

        @if (count($filterables))
            @foreach($filterables as $filterable)
                <div class="text-center">
                    <header class="block">
                        {{ $filterable->key }}
                    </header>

                    <main class="flex justify-center space-x-2">
                        @foreach(request()->input('filterable.' . $filterable->id) as $selectedValue)
                            <label class="block cursor-pointer">
                                <input data-action="change->form#changed" type="checkbox"
                                    name="filterable[{{ $filterable->id }}][]"
                                    value="{{ $selectedValue }}"
                                    class=""
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
        @endif
    </form>
</header>

<section id="results-list">
    <main class="flex flex-wrap w-full pt-12">
        <x-project.poem.list :poems="$poems" />
    </main>
</section>