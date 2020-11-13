<div id="js-poems-filter" class="relative w-full bg-white shadow-lg flex flex-wrap">
    <header class="bg-gray-100 w-full">
        <h1 style="background: #B45F06" class="font-serif text-xl text-white font-garamond font-thin p-3 pl-4 italic shadow-xl flex justify-between">
            Order By--

            <button @click="open = false">
                <x-heroicon-o-x class="w-5" />
            </button>
        </h1>

        <div class="p-4 pl-6 flex flex-wrap w-full">      
            @foreach($orderables as $orderable)
            @if ($loop->index < 2)
                <label class="pr-4 cursor-pointer">
                    <input type="radio" name="order" class="" value="{{ $orderable->id }}" 
                        wire:model="orderable" wire:click="orderableClicked({{ $orderable->id }})"
                        
                        /> 
                    <span class="mr-4">{{ $orderable->key }}</span>
                </label>
            @endif
            @endforeach
        </div>
    </header>

    <main class="w-full">
        <h1 style="background: #B45F06" class="font-serif text-xl text-white font-thin p-3 pl-4 italic shadow-xl">
            Curate by--
        </h1>

        <section class="flex flex-wrap" style="background: #f4eee9;">
            <div class="text-xs w-3/5 pt-4 pl-4 overflow-scroll h-full" style="max-height: 50vh;">
                <section class="block mb-12">
                    @if($filterables->firstWhere('id', 370))
                    <livewire:project.filterable-attribute :attribute="$filterables->firstWhere('id', 370)" 
                        :key="300"
                        :expanded="true" />
                    @endif
                </section>

                @foreach($filterables as $key => $filterable)
                    @unless($filterable->id == 370)
                    <section class="block mb-12">
                        @php 
                            // Only expand the first two Filterables
                            $expanded = $key < 2;
                        @endphp

                        <livewire:project.filterable-attribute :attribute="$filterable" :key="$key"
                            :expanded="$expanded" />
                    </section>
                    @endunless
                @endforeach
            </div>


            <section class="w-2/5 pt-4 overflow-scroll h-auto" style="background: #d9e3d2; max-height: 50vh;">
                <x-project.filter.dickinsons-birds :dickinsonsBirds="$dickinsonsBirds" :activeBirdCategories="$activeBirdCategories" />
            </section>
        </section>

        @if (optional($activeBirdCategories)->count() || optional($activeFilterables)->count())
        <section class="flex justify-center fixed bottom-0 inset-x-0">
            <button wire:click='resetAll' style="background: #6D8159" 
                class="font-serif text-md font-bold shadow-2xl text-white py-2 px-4 mb-2">
                Reset All
            </button>   
        </section>
        @endif
    </main>
</div>