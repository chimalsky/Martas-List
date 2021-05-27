<div>
    @if ($filterable->id == 131)
        <x-project.filter.year :filterable="$filterable" />
    @else 
        @foreach ($filterable->nonNullOptions as $option)
            <label class="block cursor-pointer">
               
                <span class="pl-2">
                    {{ gettype($option) }}
                </span>
            </label>
        @endforeach
    @endif
</div>