<div x-data="{open: false}"">
<section class="w-full">
    <section x-show="open" @click.away="open = false">
        @include('project.birds._filter')
    </section>
</section>

<section class="flex justify between">
    <aside class="hidden md:block sticky max-w-xs h-full top-0 pt-16">
        <button x-show="!open" @click="open = !open; scrollToFilter();" 
            style="background: #B45F06"
            class="rounded-md text-white p-2 px-6 italic text-xl font-bold font-serif mb-6">
            Curate
        </button>

        <script>
            function scrollToFilter() {
                setTimeout(function() {
                    console.log(document.querySelector('#js-poems-filter').offsetTop)
                    window.scrollTo({ 
                        left: 0, 
                        top: document.querySelector('#js-poems-filter').offsetTop, 
                        behavior: 'smooth'
                    });
                }, 150)
            }
        </script>
    </aside>

    <main class='flex flex-wrap w-full pt-12 ml-32'>
        @if ($activeBirds)
        @foreach ($activeBirds as $bird)
            <article class="pb-32 px-4 cursor-pointer w-1/3">
                @include('project.birds._single', $bird)
            </article> 
        @endforeach
        @endif
    </main>
</section>
</div>
