<label class="block cursor-pointer">
    <input {{ $attributes->whereStartsWith('data-') }}
        type="checkbox"
        name="filterable[{{ $filterable->id }}][]"
        value="{{ $option }}"
        class=""
        @if (collect(request()->input('filterable.' . $filterable->id))->contains($option))
            checked 
        @endif
        autocomplete="off" 
            />
    <span class="pl-2">
        {{ $option }}
    </span>
</label>