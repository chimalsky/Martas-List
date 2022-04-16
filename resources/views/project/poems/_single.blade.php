<div>
    <a href="@route('project.poems.show', $poem)" target="_blank">
        <header class="text-center text-xl text-black cursor-pointer">
            {{ $poem->firstLine->value ?? $poem->name }}
        </header>

        <div class="text-center mb-2">
            {{ $poem->year->value }}
        </div>

        <x-project.poem.image :poem="$poem" />
    </a>

    @if ($poem->meta)
        <footer class="text-center mt-4">
            @foreach ($poem->meta->where('resource_attribute_id', '!=', 131)
                ->groupBy('resource_attribute_id') as $metaGroup)
                @foreach ($metaGroup as $meta) 
                    @if ($meta->resource_attribute_id == 113)
                        @if ($meta->value !== 'Retained')
                        Sent to,
                    @endif

                    @if ($loop->index > 0) 
                        +
                    @endif

                    {{ $meta->value }}
                @endforeach
                <br>
            @endforeach
        </footer>
    @endif

    @if (request()->input('filterableBird') && $poem->birdCategories)
        <footer class="text-center mt-4">
            @foreach ( $poem->birdCategories->pluck('resources')->flatten() as $bird )
                @if ($loop->index > 0) 
                    +
                @endif
                {{ $bird->name }}
            @endforeach
        </footer>
    @endif
</div>