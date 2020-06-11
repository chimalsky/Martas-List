<section
    x-show="open"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-90"
    class="mt-4 z-50 p-4 text-lg absolute max-w-6xl project-filter">
    <header class="bg-gray-300 p-3 italic">
        Order By--
    </header>
    <div class="bg-yellow-100 p-4 flex flex-wrap">
        @foreach($poemDefinition->attributes->where('visibility', 1) as $attribute)
            <label class="mb-4 pr-4 cursor-pointer">
                <input type="radio" name="order" class="text-red-500" value="{{ $attribute->id }}" 
                    onchange="fetchPoems()"
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
        <div class="bg-orange-200 p-4 w-3/5">
            @foreach($poemDefinition->attributes->where('visibility', 1)->where('options') as $attribute)
                <section class="block mb-12">
                    <h1 class="text-2xl">
                        {{ $attribute->key }} 
                        <button type="button" data-attribute-id="{{ $attribute->id }}" 
                            class="js-expand-options border border-gray-500 p-1">V</span>
                    </h1>

                    <div data-attribute-options="{{ $attribute->id }}" class="grid hidden grid-cols-5 pl-8 pt-2">
                        @foreach ($attribute->options as $attributeOption)
                            @unless(is_array($attributeOption))
                                <label class="mb-2 col-span-1 font-thin cursor-pointer hover:underline">
                                    <input type="checkbox" id="meta-{{ $attribute->id }}-{{ $attributeOption }}"
                                        onchange="fetchPoems()"
                                        name="attributeOptions[{{ $attribute->id }}][{{ $attributeOption }}]" 
                                        @if ($filteredAttributeOptions->keys()->contains($attribute->id))
                                            @if (collect($filteredAttributeOptions[$attribute->id])->keys()->contains($attributeOption))
                                                checked
                                            @endif
                                        @endif/>
                                    {{ $attributeOption }}
                                </label>  
                            @endunless
                        @endforeach

                    </div>
                </section>
            @endforeach
        </div>
        <div class="bg-green-100 p-4 w-2/5">
            <h1 class="font-semibold text-xl mb-2">
                Dickinson's Birds List
            </h1>

            <section class="grid grid-cols-4">
                @foreach ($birds as $bird)
                    <input type="checkbox" name="birds[{{ $bird->id }}]" 
                        id="bird-{{ $bird->id }}"
                        class="hidden"
                        />
                    <label for="bird-{{ $bird->id }}" class="col-span-1
                        border border-indigo-400
                         cursor-pointer" >
                        {{ $bird->name }} 
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
</section>

<script>

    document.querySelectorAll('.js-expand-options').forEach(function(button) {
        button.addEventListener('click', expandOptions)
    })

    function expandOptions(ev) {
        let attr = ev.target.getAttribute('data-attribute-id')
        document.querySelector(`[data-attribute-options="${attr}"]`).classList.toggle('hidden')
    }
</script>