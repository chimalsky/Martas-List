@extends ('layouts.project')


@section ('header')
    @include('project._nav')
@endsection

@section ('content')
<section class="flex flex-wrap justify-center">
    <aside class="w-full md:w-48 lg:w-64 pr-6">
        <div x-data="{open:false}" class="my-4 pl-2 static">
            <button @click="open = !open" class="bg-orange-700 text-white p-1 px-2">
                Curate
            </button>

            <section 
                    x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-90"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-300"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-90"
                    class="mt-4 z-50 p-4 text-lg absolute w-4xl">
                    <header class="bg-gray-300 p-3 italic">
                        Order By--
                    </header>
                    <div class="bg-yellow-100 p-4 flex flex-wrap">
                        @foreach($poemDefinition->attributes->where('visibility', 1) as $attribute)
                            <label class="mb-4">
                                <input type="radio" name="order" class="w-1/3 p-2" /> 
                                <span>{{ $attribute->key }}</span>
                            </label>
                        @endforeach
                    </div>
                    <header class="bg-gray-300 p-3 italic">
                        Curate By-- 
                    </header>
                    <main class="flex flex-wrap">
                        <div class="bg-yellow-100 p-4 w-1/2">
                            @foreach($poemDefinition->attributes->where('visibility', 1)->where('options') as $attribute)
                                <h1 class="font-semibold text-xl">
                                    {{ $attribute->key }}
                                </h1>

                                <div class="flex flex-wrap pl-8 pt-2">
                                    @foreach ($attribute->options as $attributeOption)
                                        <label
                                            class="mb-2 font-thin w-1/4 cursor-pointer hover:underline">
                                            <input type="checkbox" 
                                                name="attributeOption[{{ $attribute->id }}][{{ $attributeOption }}]" 
                                                
                                                />
                                            {{ $attributeOption }}
                                        </label>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <div class="bg-green-100 p-4 w-1/2">
                            <h1 class="font-semibold text-xl mb-2">
                                Dickinson's Birds List
                            </h1>

                            <section class="flex flex-wrap">
                                @foreach ($birds as $bird)
                                    <div class="border border-indigo-600 p-2 w-1/4">
                                        {{ $bird->name }} 
                                    </div>
                                @endforeach
                            </section>

                            <h1 class="font-semibold text-xl mt-4">
                                Refers To
                            </h1>
                        </div>
                    </main>
            </section>
        </div>

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