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

        <main class="mt-4">
            <div wire:loading.remove>
                {{ $media }}
            </div>

            <div wire:loading class="justify-center flex">
                <svg class="animate-spin -ml-1 mr-3 h-10 w-10 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </div>
        </main>
    </div>
</div>