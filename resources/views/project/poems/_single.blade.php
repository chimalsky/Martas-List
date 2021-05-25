<div>
    <a href="@route('project.poems.show', $poem)"">
        <header class="text-center mb-2 text-xl text-black cursor-pointer">
            {{ $poem->firstLine->value ?? $poem->name }}
        </header>

        <x-project.poem.image :poem="$poem" />
    </a>

    @if ($poem->meta)
        <footer class="text-center mt-4">
            @foreach ($poem->meta->groupBy('resource_attribute_id') as $metaGroup)
                @foreach ($metaGroup as $meta) 
                    @if ($loop->index > 0) 
                        +
                    @endif

                    {{ $meta->value }}
                @endforeach
                <br>
            @endforeach
        </footer>
    @endif

    @if (request()->input('filterableBird') && $poem->categories)
        <footer class="text-center mt-4">
            @foreach ( $poem->categories->where('resource_type_id', 19)->pluck('resources')->flatten() as $bird )
                @if ($loop->index > 0) 
                    +
                @endif
                {{ $bird->name }}
            @endforeach
        </footer>
    @endif
</div>