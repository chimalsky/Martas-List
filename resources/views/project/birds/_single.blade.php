<div>
<a href="@route('project.birds.show', $bird)"">
    <header class="block text-2xl text-center hover:underline mb-3">
        {{ $bird->name }}
    </header>

    <x-project.bird.xc :bird="$bird" />

    @if ($bird->meta)
        <footer class="text-center mt-4">
            @foreach ($bird->meta->groupBy('resource_attribute_id') as $metaGroup)
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
</a>
</div>