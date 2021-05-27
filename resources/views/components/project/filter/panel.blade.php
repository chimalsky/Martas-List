<div>
    @if ($filterable->id == 131)
        <x-project.filter.year :filterable="$filterable" />
    @elseif ($filterable->id == 138)
        foo
    @else 
        @foreach ($filterable->nonNullOptions as $option)
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