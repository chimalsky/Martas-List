@extends ('layouts.project')


@section ('header')
    @include('project._nav')
@endsection

@section ('content')
<section class="flex flex-wrap justify-center">
    <aside class="w-full md:w-48 lg:w-64 pr-6">
        <div x-data="{open:false}" class="my-4 pl-2 static">
            <button @click="open = !open" class="bg-orange-300 text-gray-900 p-2 px-4 italic text-2xl">
                curate poems
            </button>

            @include('project.poems._filter')
        </div>
        @if ($filteredAttributes->count())
            @php 
                function getColorClass($index) {
                    $colorClass = [
                        'bg-green-200 text-green-700',
                        'bg-red-200 text-red-700',
                        'bg-orange-200 text-orange-700',
                        'bg-gray-200 text-gray-700'
                    ];

                    if ($index > (count($colorClass) - 1)) {
                        $index = $index % 4;
                    }

                    return $colorClass[$index];
                }
            @endphp 

            <section class="mt-4 px-2">
                @foreach ($filteredAttributes as $attribute)
                    <article x-data="{}" class="mb-4">
                        <div class="block flex flex-wrap">
                            <span class="italic">
                                {{ $attribute->key }} 
                            </span>
                            @foreach ($filteredAttributeOptions[$attribute->id] as $optionKey => $optionValue)
                                <span class="p-2 flex-1 {{ getColorClass($loop->index)  }}">
                                    {{ $optionKey }} 
                                </span>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </section>
        @endif

        <form class="hidden" action="@route('project.poems.index')" method="GET">
            <select name="query_key"
                class="mb-3 pl-2 w-full">
                @foreach ($poemDefinition->attributes as $attribute)
                    <option value="{{ $attribute->id }}" >
                        {{ $attribute->name }}
                    </option>
                @endforeach
            </select>

            <div x-data="" class="mt-1 flex">
                <input name="query_value"
                    class="form-input flex-1 pr-10 mr-2 sm:text-sm sm:leading-5 rounded-lg relative shadow-sm" 
                    placeholder="search..." />
                <button class="p-2 rounded-lg hover:bg-gray-500 cursor-pointer bg-gray-700 pr-3 items-center">
                    <svg class="h-5 w-5 text-gray-200" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </form>
    </aside>

    <main class="flex-1 text-gray-700 text-lg">
        <header class="text-center text-2xl block mb-32">
            Poem Archive 

            @if (!$poems->count())
                <h1 class="text-center text-lg mt-4">
                    No Poems matching your search 
                </h1>
            @endif
        </header> 
        @if ($poems->count())

            @foreach ($poems as $key => $group)
                <h1 class="text-3xl font-bold text-gray-500 block mb-8 text-center sticky top-0 bg-white">
                    {{ $key }} 
                </h1>

                <section class="flex flex-wrap">
                    @foreach($group as $poem) 
                        <article class="pb-32 px-4 cursor-pointer w-1/3">
                            @include('project.poems._single', $poem)
                        </article> 
                    @endforeach
                </section>
            @endforeach
        @endif
    </main>
</section>

@endsection