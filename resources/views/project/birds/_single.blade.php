<div>
<a href="@route('project.birds.show', $bird)" target="_blank">
    <header class="block text-2xl text-center hover:underline mb-3">
        {{ $bird->name }}
    </header>

    <x-project.bird.xc :bird="$bird" />
</a>
</div>