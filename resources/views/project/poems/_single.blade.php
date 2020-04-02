<div>
    <a href="@route('project.poems.show', $poem->id)">
        <p class="text-center mb-2">
            {{ $poem->meta->where('resource_attribute_id', 84)->first()->value ?? null }}
        </p>

        @php 
            $imageCount = $poem->getMedia()->count()
        @endphp

        <section class="block grid gap-4
            @if ($imageCount == 2)
                grid-cols-2
            @elseif ($imageCount == 3)
                grid-cols-3
            @elseif ($imageCount == 4)
                grid-cols-2
            @elseif ($imageCount == 5)
                grid-cols-3
            @endif
            ">
            @forelse ($poem->getMedia() as $medium)
                @if (Str::contains($medium->mime_type, 'image'))
                    <div class="flex justify-center">
                        <img class="w-24 px-1 shadow-lg" 
                        src="{{ $medium->getUrl('thumb') }}" />
                    </div>
                @endif
            @empty 
                <div class="flex justify-center">
                    <div class="w-24 h-40 border-4 border-gray-300">
                    </div>
                </div>
            @endforelse
        </section>
    </a>
</div>