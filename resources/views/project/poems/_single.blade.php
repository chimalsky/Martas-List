<div>
    <a href="@route('project.poems.show', $poem)"">
        <header class="text-center mb-2 text-xl text-black cursor-pointer">
            {{ $poem->firstLine->value ?? $poem->name }}
        </header>

        <x-project.poem.image :poem="$poem" />
    </a>

    @if ($poem->meta)
        <footer class="text-center mt-4">
            @foreach ($poem->meta as $meta)
                {{ $meta->value }} <br>
            @endforeach
        </footer>
    @endif
</div>