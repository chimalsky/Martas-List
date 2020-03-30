<div>
    <a href="@route('project.poems.show', $poem->id)">
        <p class="text-center mb-2">
            {{ $poem->meta->where('resource_attribute_id', 84)->first()->value ?? null }}
        </p>

        <section class="block flex justify-center">
            @forelse ($poem->getMedia() as $medium)
                @if (Str::contains($medium->mime_type, 'image'))
                    <img class="w-24 px-1 inline-block shadow-lg" src="{{ $medium->getUrl('thumb') }}" />
                @endif
            @empty 
                <div class="w-24 h-40 border-4 border-gray-300">
                    
                </div>
            @endforelse
        </section>
    </a>
</div>