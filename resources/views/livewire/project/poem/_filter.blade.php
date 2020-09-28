<div id="js-poems-filter" class="relative w-full bg-white shadow-lg flex flex-wrap">
    <header class="bg-gray-100 w-full">
        <h1 style="background: #B45F06" class="font-serif text-2xl text-white font-garamond font-thin p-3 italic shadow-xl flex justify-between">
            Order By--

            <button @click="open = false">
                <x-heroicon-o-x class="w-8" />
            </button>
        </h1>

        <div class="p-4 flex flex-wrap w-full">            
            @foreach($orderables as $orderable)
            @if ($loop->index < 3)
                <label class="mb-4 pr-4 cursor-pointer">
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
        <h1 style="background: #B45F06" class="font-serif text-2xl text-white font-thin p-3 italic shadow-xl">
            Curate by--
        </h1>

        <section class="flex flex-wrap" style="background: #f4eee9;">
            <div class="text-xs w-3/5 pt-4 pl-4">
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
                <x-project.filter.dickinsons-birds :dickinsonsBirds="$dickinsonsBirds" :activeBirdCategories="$activeBirdCategories" />
            </section>
        </section>
    </main>
</div>