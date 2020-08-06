<div id="js-poems-filter" class="relative w-full bg-white shadow-lg flex flex-wrap">
    <header class="bg-gray-100 w-full">
        <h1 class="font-serif text-2xl bg-orange-700 text-white font-garamond font-thin p-3 italic shadow-xl flex justify-between">
            Order By--

            <button @click="open = false">
                X
            </button>
        </h1>

        <div class=" p-4 flex flex-wrap w-full">
            
            @foreach($orderables as $orderable)
                @if ($loop->index < 3)
                    <label class="mb-4 pr-4 cursor-pointer">
                        <input type="radio" name="order" class="" value="{{ $orderable->id }}" 
                            wire:model="orderable"
                            wire:click="sort( {{ $orderable->id  }} )"
                            /> 
                        <span class="mr-4">{{ $orderable->key }}</span>
                    </label>
                @endif
            @endforeach

        </div>
    </header>

    <main class="w-full">
        <h1 class="font-serif text-2xl bg-orange-700 text-white font-thin p-3 italic shadow-xl">
            Curate by--
        </h1>

        <section class="flex flex-wrap bg-yellow-100">

            <div class="text-xs w-3/5 pt-4">
                @foreach($filterables as $key => $filterable)
                    <section class="block mb-12">
                        @php 
                            // Only expand the first two Filterables
                            $expanded = $key < 2;
                        @endphp

                        <livewire:project.filterable-attribute :attribute="$filterable" :key="$key"
                            :expanded="$expanded" />
                    </section>
                @endforeach
            </div>


            <section class="w-2/5 pt-4 bg-green-100">
                <header class="block mb-2 font-serif font-bold text-xl">
                    Dickinson's Bird List
                </header>

                <main class="mx-auto grid grid-cols-4 bg-yellow-100">
                    @foreach ($dickinsonsBirds->sortBy('name') as $bird)
                        <label wire:click="filterByBird({{ $bird->id }})"
                            class="col-span-1
                            border border-orange-500 p-2
                            cursor-pointer
                            @if ($activeBirdCategories->contains($bird->id))
                                bg-yellow-400 font-bold
                            @endif
                                " >
                            {{ $bird->name }} 
                        </label>
                    @endforeach
                </main>

                <footer class="flex justify-center mt-4">
                    <button wire:click='resetBirds' class="font-serif font-bold bg-green-600 shadow-2xl text-white py-2 px-4">
                        Unselect All
                    </button>
                </footer>
            </section>
        </section>
    </main>
</div>