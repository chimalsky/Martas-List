<div class="relative w-full bg-white shadow-lg flex flex-wrap">
    <header class="bg-gray-100 w-full">
        <h1 class="bg-orange-700 text-white font-thin text-xl p-3 italic shadow-xl flex justify-between">
            Order By--

            <button @click="open = false">
                X
            </button>
        </h1>

        <div class=" p-4 flex flex-wrap w-full">
            @foreach($orderables as $orderable)
                <label class="mb-4 pr-4 cursor-pointer">
                    <input type="radio" name="order" class="text-red-500" value="{{ $orderable->id }}" 
                        wire:model="orderable"
                        wire:click="sort( {{ $orderable->id  }} )"
                        /> 
                    <span class="mr-4">{{ $orderable->key }}</span>
                </label>
            @endforeach

        </div>
    </header>

    <main class="w-full">
        <h1 class="bg-orange-700 text-white font-thin text-xl p-3 italic shadow-xl">
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
                <header class="block mb-2 text-xl">
                    Dickinson's Bird List
                </header>

                <main class="mx-auto grid grid-cols-4 bg-yellow-100">
                    @foreach ($dickinsonsBirds as $bird)
                        <label wire:click="filterByBird({{ $bird->id }})"
                            for="bird-{{ $bird->id }}" class="col-span-1
                            border border-orange-500 p-3
                            cursor-pointer
                            @if ($activeBirds->contains($bird->id))
                                bg-yellow-400 font-bold
                            @endif
                                " >
                            {{ $bird->name }} 
                        </label>
                    @endforeach
                </main>

                <footer class="flex justify-center mt-4">
                    <button wire:click='resetBirds' class="bg-green-500 shadow-2xl text-white py-2 px-4">
                        Unselect All
                    </button>
                </footer>
            </section>
        </section>
    </main>
</div>