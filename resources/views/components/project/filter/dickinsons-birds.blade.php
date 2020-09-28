<header class="block ml-6 mb-2 font-serif font-bold text-xl">
    Dickinson's Bird List
</header>

<div class="flex flex-wrap">
    <main class="mx-auto w-11/12 grid grid-cols-4 bg-yellow-100">
        @foreach ($dickinsonsBirds->sortBy('name') as $bird)
            <label wire:click="updateSelectedBird({{ $bird->id }})"
                class="col-span-1
                border border-orange-500 p-2
                cursor-pointer
                @if (optional($activeBirdCategories)->contains($bird->id))
                    font-bold
                @endif
                    "
                style="
                    @unless (optional($activeBirdCategories)->contains($bird->id))
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