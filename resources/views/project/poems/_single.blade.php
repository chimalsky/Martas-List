<div>
    <a href="@route('project.poems.show', $poem)" target="_blank">
        <header class="text-center mb-2 text-xl text-black cursor-pointer">
            {{ $poem->headline_value ?? $poem->name }}
        </header>

        <x-project.poem.image :poem="$poem" />
    </a>
</div>