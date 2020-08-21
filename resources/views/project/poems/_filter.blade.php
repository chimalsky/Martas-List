<div id="js-poems-filter" class="relative w-full bg-white shadow-lg flex flex-wrap">
    <header class="bg-gray-100 w-full">
        <h1 style="background: #B45F06" class="font-serif text-2xl text-white font-garamond font-thin p-3 italic shadow-xl flex justify-between">
            Order By--

            <button @click="open = false">
                <x-heroicon-o-x class="w-8" />
            </button>
        </h1>

        <style>

            /* Hide the browser's default checkbox */
            .container input {
                opacity: 0;
                cursor: pointer;
                height: 0;
                width: 0;
            }

            /* Create a custom checkbox */
            .checkmark {
                position: absolute;
                top: 0;
                left: 0;
                height: 25px;
                width: 25px;
                background-color: transparent;
            }

            /* Create the checkmark/indicator (hidden when not checked) */
            .checkmark:after {
            content: "";
            position: absolute;
            display: none;
            }

            /* Show the checkmark when checked */
            .container input:checked ~ .checkmark:after {
            display: block;
            }

            /* Style the checkmark/indicator */
            .container .checkmark:after {
            left: 9px;
            bottom: 3px;
            width: 12px;
            height: 25px;
            border: solid green;
            border-width: 0 4px 4px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
            }
        </style>


        <div class="p-4 flex flex-wrap w-full">
            
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
        <h1 style="background: #B45F06" class="font-serif text-2xl text-white font-thin p-3 italic shadow-xl">
            Curate by--
        </h1>

        <section class="flex flex-wrap" style="background: #f4eee9;">

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


            <section class="w-2/5 pt-4" style="background: #d9e3d2">
                <header class="block ml-6 mb-2 font-serif font-bold text-xl">
                    Dickinson's Bird List
                </header>

                <div class="flex flex-wrap">
                    <main class="mx-auto w-11/12 grid grid-cols-4 bg-yellow-100">
                        @foreach ($dickinsonsBirds->sortBy('name') as $bird)
                            <label wire:click="filterByBird({{ $bird->id }})"
                                class="col-span-1
                                border border-orange-500 p-2
                                cursor-pointer
                                @if ($activeBirdCategories->contains($bird->id))
                                   font-bold
                                @endif
                                    "
                                style="
                                    @unless ($activeBirdCategories->contains($bird->id))
                                        background: #efefef;
                                    @else
                                        background: #CC9A00;
                                        color: white;
                                    @endunless
                                ">
                                {{ $bird->name }} 
                            </label>
                        @endforeach
                    </main>
                </div>

                @if ($activeBirdCategories->count() > 0)
                    <footer class="flex justify-center mt-4">
                        <button wire:click='resetBirds' style="background: #6D8159" class="font-serif font-bold shadow-2xl text-white py-2 px-4">
                            Unselect All
                        </button>   
                    </footer>
                @endif
            </section>
        </section>
    </main>

    @if ($this->isCurating)
        <footer class="justify-center flex w-full  py-5">
            <button wire:click="resetAll" class="bg-green-700 border-2 text-white py-2 px-4 border-green-600 shadow-2xl">
                Reset All Filters
            </button>
        </footer>
    @endif
</div>