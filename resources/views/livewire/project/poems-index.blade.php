<div>
    <button wire:click="toggleFilter">
        Curate Poems
    </button>

    @if ($filterOpened)
        <header class="bg-gray-300 p-3 italic">
            Order By--
        </header>
            
        <div class="bg-yellow-100 p-4 flex flex-wrap">
            @foreach($orderables as $orderable)
                <label class="mb-4 pr-4 cursor-pointer">
                    <input type="radio" name="order" class="text-red-500" value="{{ $orderable->id }}" 
                        wire:change="sort( {{ $orderable->id  }} )"
                        /> 
                    <span class="mr-4">{{ $orderable->key }}</span>
                </label>
            @endforeach

        </div>

        <div class="">
            @if(true)

                @foreach($filterables->take(1) as $filterable)
                    <section class="block mb-12">
                        
                        <livewire:project.filterable-attribute :attribute="$filterable" />
                        
                    </section>
                @endforeach
            @endif
        </div>
    @endif

    <section class="flex flex-wrap">
        @if ($poems)
            @foreach ($poems as $poem)
                <article class="pb-32 px-4 cursor-pointer w-1/3">
                    {{ $poem->id }} -- {{ $poem->name }}
                </article> 
            @endforeach

        @else 
            No Poems
        @endif
    </section>

</div>
