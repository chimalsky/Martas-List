<div class="grid grid-cols-3 gap-2">
    @foreach ($filterable->options as $option)
        <label class="cursor-pointer @if ($option == 'Year unknown') col-span-2 @else col-span-1 @endif">
            <input data-action="change->form#changed" type="checkbox"
                name="filterable[{{ $filterable->id }}][]"
                value="{{ $option }}"
                class=""
                @if (collect(request()->input('filterable.' . $filterable->id))->contains($option))
                    checked 
                @endif
                autocomplete="off" 
                    />
            <span class="pl-1">
                @if ($option == 'Year unknown') 
                    Year unknown
                @else
                    {{ preg_replace("/[^0-9]/", "", $option ) }} 
                @endif
            </span>
        </label>
    @endforeach
</div>