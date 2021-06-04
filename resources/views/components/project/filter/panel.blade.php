<div>
    @if ($filterable->id == 131)
        <x-project.filter.year :filterable="$filterable" />
    @elseif ($filterable->id == 103) 
        <x-project.filter.nested :filterable="$filterable" />
    @else
        @foreach ($filterable->nonNullOptions as $option)
            @php
                if (is_array($option)) {
                    $option = $option['_name'];
                }
            @endphp 

            <label class="block cursor-pointer">
                <input data-action="change->form#changed" type="checkbox"
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
        @endforeach
    @endif
</div>