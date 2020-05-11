<div x-show="open">
    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
    class="hidden fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center fixed inset-0 transition-opacity">
        <div class="absolute inset-0 bg-gray-500 opacity-75">
        </div>
    </div>

        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full lg:max-w-4xl">
        {{ html()->form('POST', route('attribute.options.sort', $attribute))->open() }}
        <div class="bg-black px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                
                <section class="sortable mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex flex-wrap ">
                    @if ($attribute->options)
                        @foreach ($attribute->options as $index => $option) 
                            @if (is_array($option))
                                <div class="block my-2 mx-2 cursor-move hover:bg-indigo-900 p-1"
                                    x-data="{ depth: {{ $loop->depth }} }">
                                    <h1 class="font-bold text-2xl">
                                        {{ $option['_name'] }}
                                    </h1>

                                    {{ html()->hidden('optionBlocks[]', $option['_name']) }}

                                    <span class="text-gray-500">
                                        {{ $index + 1 }}
                                    </span>
                                 
                                    @foreach ($option['_items'] as $item)
                                        {{ html()->hidden("optionBlocks[{$option['_name']}]", $item)
                                            ->class('form-input w-full mb-4') }}
                                        
                                        {{ $item }}
                                    @endforeach
                                </div>
                            @else
                                <article class="block my-2 mx-2 cursor-move hover:bg-indigo-900 py-1">
                                    <span class="text-gray-500">
                                        {{ $index + 1 }}
                                    </span>
                                    {{ html()->hidden('options[]', $option) }}
                                    {{ $option }}
                                </article>
                            @endif
                        @endforeach
                    @else 
                        There are no options to order yet!!
                    @endif

                </section>
            </div>
        </div>
        <div class="bg-gray-900 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                <button class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    Change order
                </button>
            </span>
            <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                <button @click.prevent="open = false" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    Nevermind
                </button>
            </span>
        </div>
        {{ html()->form()->close() }}
    </div>
</div>