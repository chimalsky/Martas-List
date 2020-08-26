<div>
    <div class="border-b border-gray-200">
        <nav class="-mb-px space-x-4">
            @foreach ($medias as $medium)
                @if (Str::contains($medium->mime_type, 'image'))
                    <button 
                        wire:click="setMedia({{ $medium->id }})"
                        class="bg-green-200 hover:bg-indigo-100 border-b-2 border-transparent pb-2
                            @if ($media->id == $medium->id) border-indigo-500 @endif
                            hover:border-gray-300 focus:text-gray-700 ">
                            <img src="{{ $medium->getUrl('thumb') }}" />
                    </button>
                @endif
            @endforeach
        </nav>

        <div class="mt-4 shadow-2xl">
            {{ $media }}
        </div>
    </div>
</div>