    <div>
    <a href="@route('project.poems.show', $poem)">
        <header class="text-center mb-2 text-xl text-black cursor-pointer">
            {{ $poem->headline_value ?? $poem->name }}
        </header>

        @if($placeholderMeta = $poem->meta()->firstWhere('resource_attribute_id', 149))
            <section class="flex justify-center">
                @if ($placeholderMeta->value == 'placeholder for LOST or DESTROYED MS')
                    <img class="w-16 inline-block" src="/img/coming-soon.jpg" />
                @elseif ($placeholderMeta->value == 'placeholder for MS we need to request digital image for')
                    <img class="w-20 inline-block" src="/img/lost-or-destroyed.png" />
                @endif
            </section>
        @else
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
                        <div class="flex justify-center cursor-pointer">
                            <img class="w-24 px-1 shadow-lg" 
                            src="{{ $medium->getUrl('thumb') }}" />
                        </div>
                    @endif
                @empty 
                    <div class="flex justify-center cursor-pointer">
                        <div class="w-24 h-40 border-4 border-gray-300">
                        </div>
                    </div>
                @endforelse
            </section>
        @endif

        @unless ($poem->headline_value == $poem->queryable_meta_value)
            <p class="text-center text-xl">
                {{ $poem->queryable_meta_value }}
            </p>
        @endunless
    </a>

    @if($query)
        <p id="transcription-{{ $poem->id }}" class="transcription mt-12 text-black font-display">
            @php 
                $stripped = strip_tags($poem->transcription->value);

                $strpos = stripos($stripped, $query);
                

                if ($strpos < 50) {
                    $start = 0;
                } else {
                    $start = $strpos - 50;
                }

                $end = $start + 50;

                if ($end + 50 > strlen($stripped)) {
                    $end = strlen($stripped);
                }
            @endphp

            {{ substr($stripped, $start, $end) }}
        </p>

        <script>
            
            var markInstance = new Mark(document.querySelector("#transcription-{{ $poem->id }}"));

            var keyword = '{{ $query }}';

            
            // Remove previous marked elements and mark
            // the new keyword inside the context
        
            markInstance.mark(keyword, {});
                
        </script>

    @endif
</div>