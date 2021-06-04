<div>
    <a href="@route('project.poems.show', $poem)"">
        <header class="text-center text-xl text-black cursor-pointer">
            {{ $poem->firstLine->value ?? $poem->name }}
        </header>

        <div class="text-center mb-2">
            {{ $poem->year->value }}
        </div>

        <x-project.poem.image :poem="$poem" />
    </a>
</div>