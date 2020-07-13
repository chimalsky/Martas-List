<div class="flex justify between">
<section x-data="{open: false}">
    <aside class="max-w-xs">
        <input wire:model.debounce.900ms="query" placeholder="search by first line"
            class="block mb-4 border-4 border-gray-700 rounded-full pl-4 p-2 placeholder-gray-800" /> 

        <button @click="open = !open" class="bg-gray-500 rounded-md text-white p-2 px-6 italic text-lg">
            Curate
        </button>
    </aside>

    <section x-show="open">
        <div class="max-w-6xl absolute bg-white shadow-lg flex flex-wrap">
            <header class="bg-gray-100 w-full">
                <h1 class="bg-gray-300 p-3 italic flex justify-between">
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

            <main>
                <h1 class="bg-gray-300 p-3 italic">
                    Curate By--
                </h1>

                <section class="flex flex-wrap bg-yellow-100">

                    <div class="text-xs w-3/5 pt-4">
                        @foreach($filterables as $key => $filterable)
                            <section class="block mb-12">
                                @php 
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

                        <main class="p-4 mx-auto grid grid-cols-4">
                            @foreach ($birds as $bird)
                                <label wire:click="filterByBird({{ $bird->id }})"
                                    for="bird-{{ $bird->id }}" class="col-span-1
                                    border border-indigo-400 p-3
                                    cursor-pointer
                                    @if ($activeBirds->contains($bird->id))
                                        bg-indigo-700 text-white
                                    @endif
                                        " >
                                    {{ $bird->name }} 
                                </label>
                            @endforeach
                        </main>
                    </section>
                </section>
            </main>
        </div>
    </section>
</section>

<section class="flex flex-wrap w-full">
    @if ($poems->count())
        @foreach ($poems as $poem)
            <article class="pb-32 px-4 cursor-pointer w-1/3">
                @include('project.poems._single', $poem)
            </article> 
        @endforeach

        <nav class="w-full">
            {{ $poems->links() }}
        </nav>
    @else 
        <div class="items-center flex mx-auto text-center text-3xl text-gray-500 font-semibold">
            No poems matching your curation
        </div>
    @endif
</section>
</div>
