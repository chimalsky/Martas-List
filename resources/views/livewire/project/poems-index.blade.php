<div>
    <button wire:click="$toggle('filterOpened')">
        Curate Poems
    </button>

    @if ($filterOpened)
        <header class="bg-gray-300 p-3 italic">
            Order By--
        </header>
        <div class="bg-yellow-100 p-4 flex flex-wrap">
            @foreach($orderables as $attribute)
                <label class="mb-4 pr-4 cursor-pointer">
                    <input type="radio" name="order" class="text-red-500" value="{{ $attribute->id }}" 
                        wire:change="sort( {{ $attribute->id  }} )"
                        /> 
                    <span class="mr-4">{{ $attribute->key }}</span>
                </label>
            @endforeach

        </div>

        <div>
           
        </div>
    @endif

    <section class="flex flex-wrap">

        @if ($activePoems && $activePoems->count())
            @foreach ($activePoems as $poem)
                <article class="pb-32 px-4 cursor-pointer w-1/3">
                    @include('project.poems._single', $poem)
                </article> 
            @endforeach
            {{ $activePoems->links() }}
        @else 
            No Poems
        @endif
    </section>

</div>
