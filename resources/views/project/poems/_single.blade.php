<div>
    <a href="@route('project.poems.show', $poem)">
        <header class="text-center mb-2 text-xl text-black cursor-pointer">
            {{ $poem->headline_value ?? $poem->name }} {{ $poem->queryable_meta_value }}
        </header>

        <x-project.poem.image :poem="$poem" />
    </a>

    
</div>