<div>
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex">
            @foreach ($resource->getMedia() as $medium)
                @if (Str::contains($medium->mime_type, 'image'))
                    <button 
                        wire:click="setMedia({{ $medium->id }})"
                        class="py-4 px-8 text-center border-b-2 border-transparent font-medium text-lg leading-5 text-gray-500 hover:bg-indigo-100 
                            @if ($media->id == $medium->id) border-indigo-500 @endif
                            hover:border-gray-300 focus:text-gray-700 ">
                        {{ $loop->index + 1 }}
                    </button>
                @endif
            @endforeach
        </nav>

        <div class="mt-4">
            {{ $media }}
        </div>
    </div>
</div>