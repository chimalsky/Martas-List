<div>
    <header class="block text-md text-center hover:underline mb-3 text-red-800 font-serif">
        {{ $bird->name }}
    </header>

    @foreach ($bird->getMedia() as $sonogram)
        @if (Str::contains($sonogram->mime_type, 'image'))
            <div class="bg-cover bg-center w-full h-24" 
                style="background-image: url('{{ $sonogram->getUrl('thumb') }}')">
            </div>
        @endif
    @endforeach 

    <footer class="flex justify-center">
        @if ($audio = $bird->getFirstMedia())
            @if (Str::contains($audio->mime_type, 'audio'))
                <audio class="mt-2" controls
                    src="{{ $audio->getUrl() }}">
                        Your browser does not support the
                        <code>audio</code> element.
                </audio>                    
            @endif
        @endif
    </footer>
</div>