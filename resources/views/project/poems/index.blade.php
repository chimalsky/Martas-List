@extends ('layouts.project')


@section ('header')
    @include('project._nav')
@endsection

@section ('content')
<section class="flex flex-wrap justify-center">
    <aside class="w-full md:w-48 lg:w-64 pr-6">
        <form action="@route('project.poems.index')" method="GET">
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

            @if ($queries->count())
            <section class="mt-4 px-2">
                @foreach ($queries as $query)
                    <article x-data="{}">
                        <input type="hidden" name="query_values[]" 
                            value="{{ $query->query }}" />
                        <input type="hidden" name="query_keys[]" 
                            value="{{ $query->attribute->id }}" />

                        <div class="block">
                            {{ $query->attribute->name }} :
                            <span class="p-2 bg-red-200">
                                {{ $query->query }}
                            </span>
                        </div>
                    </article>
                @endforeach
            </section>
            @endif
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

        <section class="flex flex-wrap">
            @foreach ($poems as $poem)
                <article class="pb-32 px-4 cursor-pointer w-1/3">
                    @include('project.poems._single', $poem)
                </article> 
            @endforeach
        </section>
    </main>
</section>

@endsection