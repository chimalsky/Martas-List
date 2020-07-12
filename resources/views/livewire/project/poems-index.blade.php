<div>
    <button wire:click="toggleFilter">
        Curate Poems {{ $orderDirection }}
    </button> 

    @if ($filterOpened)
        <section class="max-w-4xl absolute bg-white shadow-lg">
            <header class="bg-gray-300 p-3 italic">
                Order By--
            </header>
                
            <div class="bg-yellow-100 p-4 flex flex-wrap">
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

            <div class="">
                @foreach($filterables as $key => $filterable)
                    <section class="block mb-12">
                        <livewire:project.filterable-attribute :attribute="$filterable" :key="$key" />
                    </section>
                @endforeach
            </div>
        </section>
    @endif

    <section class="flex flex-wrap">
        @if ($poems->count())
            @foreach ($poems as $poem)
                <article class="pb-32 px-4 cursor-pointer w-1/3">
                    @include('project.poems._single', $poem)
                </article> 
            @endforeach

            {{ $poems->links() }}
        @else 
            No Poems
        @endif
    </section>

</div>
