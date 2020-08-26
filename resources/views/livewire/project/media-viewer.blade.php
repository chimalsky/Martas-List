<div>
    <div class="border-b border-gray-200">
        <nav class="-mb-px space-x-4">
            @foreach ($medias as $medium)
                @if (Str::contains($medium->mime_type, 'image'))
                    <button 
                        wire:click="setMedia({{ $medium->id }})"
                        class="w-20 hover:bg-indigo-100 border-b-2 border-transparent pb-2
                            @if ($media->id == $medium->id) border-indigo-500 @endif
                            hover:border-gray-300 focus:text-gray-700 ">
                            <img class="object-contain" src="{{ $medium->getUrl('thumb') }}" />
                    </button>
                @endif
            @endforeach
        </nav>

        <main class="mt-4 shadow-2xl">
            <div wire.loading.remove>
                {{ $media }}
            </div>

            <div wire.loading>
                Loading
            </div>
        </main>
    </div>
</div>