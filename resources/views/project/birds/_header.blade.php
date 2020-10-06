<h1 class="text-4xl font-hairline text-center">
    <a href="@route('project.birds.show', $bird)">
        {{ $bird->firstMetaByAttribute(500)->value ?? null }}
        <span class="italic">
            ({{ $bird->firstMetaByAttribute(501)->value ?? null }})
        </span>
    </a>

    | 

    <a href="@route('project.bird.poems', $bird)" class="italic">
        Affiliated Manuscripts
    </a>

    | 

    <a href="@route('project.birds.data', $bird)">
        Further Data
    </a>
</h1>