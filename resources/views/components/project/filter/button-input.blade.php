<label class="button-input cursor-pointer block mb-4 border border-gray-700 p-2">
    <input {{ $attributes->whereStartsWith('data-') }}
        type="checkbox"
        name="filterable[{{ $filterable->id }}][]"
        value="{{ $option }}"
        @if (collect(request()->input('filterable.' . $filterable->id))->contains($option))
            checked 
        @endif
        autocomplete="off" 
            />
    <span class="">
        {{ $option }}
    </span>
</label>