<div>
    <div class="border-b border-gray-200">
        <nav class="-mb-px space-x-4">
            @foreach ($medias as $medium)
                @if (Str::contains($medium->mime_type, 'image'))
                    <button 
                        @if ($loop->index === 0)
                            id="first-media-button"
                        @endif
                        wire:click="setMedia({{ $medium->id }})"
                        class="w-20 hover:bg-indigo-100 border-b-2 border-transparent pb-2
                            @if ($media->id == $medium->id) border-indigo-500 @endif
                            hover:shadow-lg">
                            <img class="object-contain" src="{{ $medium->getUrl('thumb') }}" />
                    </button>
                @endif
            @endforeach

            <script>
                setTimeout(function() {
                    document.querySelector('#first-media-button').click();
                }, 600);
            </script>
        </nav>

        <main class="mt-4">
            <div wire:loading.remove>
                {{ $media }}
            </div>

            <div wire:loading.class.remove="hidden" class="justify-center flex hidden">
                <div wire:loading class="animate-ping h-12 w-12 text-gray-700 hover:text-gray-500 focus:outline-none 
                    focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 
                    transition ease-in-out duration-150">
                    <img class="object-contain h-screen" src="{{ asset('img/bird-icon-round.png') }}" />
                </div>
            </div>
        </main>
    </div>
</div>