<div class="grid grid-cols-2 w-full gap-4">
    @foreach ($dickinsonsBirds->sortBy('name') as $bird)
        <label class="col-span-1 text-center cursor-pointer">
            <input data-action="change->form#changed" type="checkbox"
                name="filterableBird[{{ $bird->id }}][]"
                value="{{ $bird->id }}"
                class=""
                @if (collect(request()->input('filterableBird.' . $bird->id))->contains($bird->id))
                    checked 
                @endif
                autocomplete="off" 
                    />
            {{ $bird->name }} 
        </label>
    @endforeach
</div>
