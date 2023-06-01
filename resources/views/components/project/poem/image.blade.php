<div @routeIs('project.affiliated.poems') style="min-height: 120px;" @endrouteIs>
    @if($poem->placeholder)
        <section class="flex justify-center">
            @if ($poem->placeholder->value == 'placeholder for LOST or DESTROYED MS')
                <img class="w-20 h-20 inline-block @routeIs('project.affiliated.poems') mt-6 @endrouteIs" loading="lazy" src="/img/lost-or-destroyed.png" alt="placeholder image for LOST or DESTROYED MS" />
            @elseif ($poem->placeholder->value == 'placeholder for MS we need to request digital image for')
                <img class="w-16 h-24 inline-block" loading="lazy" src="/img/coming-soon.jpg" alt="placeholder image for MS we need to request digital image for" />
            @endif
        </section>
    @else
        @php 
            $imageCount = $poem->facsimiles->count()
        @endphp

        @if ($imageCount)
            <section class="flex flex-wrap justify-center gap-2">
                @foreach ($poem->facsimiles as $medium)
                    <div class="flex justify-center cursor-pointer">
                        <img class="w-20 px-1 shadow-lg facs-thumb" 
                        loading="lazy"
                        src="{{ $medium->getUrl('thumb') }}" />
                    </div>
                @endforeach
            </section>
        @else 
            <div class="flex justify-center cursor-pointer">
                <div class="w-24 h-40 border-4 border-gray-300">
                </div>
            </div>
        @endif
    @endif
</div>


