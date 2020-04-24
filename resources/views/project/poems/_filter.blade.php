<form action="@route('project.poems.index')" method="get" 
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
            <label class="mb-4 pr-4 cursor-pointer">
                <input type="radio" name="order" class="text-red-500" value="{{ $attribute->id }}" 
                    @if($sortedAttribute == $attribute->id) checked @endif
                /> 
                <span class="mr-4">{{ $attribute->key }}</span>
            </label>
        @endforeach
    </div>
    <header class="bg-gray-300 p-3 italic">
        Curate By-- 
    </header>
    <main class="flex flex-wrap">
        <div class="bg-orange-200 p-4 w-1/2">
            @foreach($poemDefinition->attributes->where('visibility', 1)->where('options') as $attribute)
                <h1 class="font-semibold text-xl">
                    {{ $attribute->key }}
                </h1>

                <div class="flex flex-wrap pl-8 pt-2">
                    @foreach ($attribute->options as $attributeOption)
                        <label
                            class="mb-2 font-thin w-1/4 cursor-pointer hover:underline">
                            <input type="checkbox" 
                                name="attributeOptions[{{ $attribute->id }}][{{ $attributeOption }}]" 
                                @if ($filteredAttributeOptions->keys()->contains($attribute->id))
                                    @if (collect($filteredAttributeOptions[$attribute->id])->keys()->contains($attributeOption))
                                        checked
                                    @endif
                                @endif
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
                    <label class="border border-indigo-600 p-2 w-1/4 
                        hover:bg-indigo-100 cursor-pointer" >
                        {{ $bird->name }} 

                        <input type="checkbox" name="birds[{{ $bird->id}}]" 
                            id="bird-{{ $bird->id }}"
                            class=""
                            />
                    </label>
                @endforeach
            </section>

            <h1 class="font-semibold text-xl mt-4">
                Refers To
            </h1>
        </div>
    </main>

    <footer class="flex justify-center p-2 bg-yellow-200">
        <button class="p-3 text-2xl font-semibold border border-black">
            Curate
        </button>
    </footer>
</form>