<div id="js-poems-filter" class="relative w-full bg-white shadow-lg flex flex-wrap">
    <header class="bg-gray-100 w-full">
        <h1 style="background: #B45F06" class="font-serif text-2xl text-white font-garamond font-thin p-3 italic shadow-xl flex justify-between">
            <span class="text-center w-full pl-6">
                Sort By--
            </span>

            <button class="float-right" @click="open = false">
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


        <div class="p-4 w-1/3">
            <header class="block ml-6 mb-2 font-serif font-bold text-xl">
                Dickinson's Bird List
            </header>

            <div class="flex flex-wrap">
                <main class="mx-auto w-11/12 grid grid-cols-3 bg-yellow-100">
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

        </div>
    </header>

    <main class="w-full">
        
       
    </main>

</div>