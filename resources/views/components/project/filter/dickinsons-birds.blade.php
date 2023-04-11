@php
    $dickinsonsBirds = App\ResourceCategory::with('connections')
        ->where('resource_type_id', App\Project\Bird::$resource_type_id)->get();
@endphp

<div class="w-full gap-4 text-sm" style="padding-left: 24px">
    @foreach ($dickinsonsBirds->sortBy('name') as $bird)
        <label class="cursor-pointer block">
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
    <label class="cursor-pointer block">
        <input data-action="change->form#changed" type="checkbox"
            name="filterableBird[unnamed][]"
            value="unnamed"
            class=""
            @if (collect(request()->input('filterableBird.unnamed'))->contains('unnamed'))
                checked 
            @endif
            autocomplete="off" 
                />
        Unnamed bird(s) 
    </label>
</div>
