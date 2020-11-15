<div>
    @if($placeholderMeta = $poem->meta()->firstWhere('resource_attribute_id', 149))
        <section class="flex justify-center">
            @if ($placeholderMeta->value == 'placeholder for LOST or DESTROYED MS')
                <img class="w-20 h-20 inline-block" src="/img/lost-or-destroyed.png" />
            @elseif ($placeholderMeta->value == 'placeholder for MS we need to request digital image for')
                <img class="w-16 h-24 inline-block" src="/img/coming-soon.jpg" />
            @endif
        </section>
    @else
        @php 
            $imageCount = $poem->getMedia()->count()
        @endphp

        <section class="block flex justify-center">
            
            <div class="grid gap-8
                @if ($imageCount == 2)
                    grid-cols-2 w-1/2
                @elseif ($imageCount == 3)
                    grid-cols-3
                @elseif ($imageCount == 4)
                    grid-cols-2 w-1/2
                @elseif ($imageCount == 5)
                    grid-cols-3
                @endif
                ">
                @forelse ($poem->getMedia() as $medium)
                    @if (Str::contains($medium->mime_type, 'image'))
                        <div class="flex justify-center cursor-pointer">
                            <img class="w-24 px-1 shadow-lg facs-thumb" 
                            src="{{ $medium->getUrl('thumb') }}" />
                        </div>
                    @endif
                @empty 
                    <div class="flex justify-center cursor-pointer">
                        <div class="w-24 h-40 border-4 border-gray-300">
                        </div>
                    </div>
                @endforelse
            </div>
        </section>
    @endif
</div>