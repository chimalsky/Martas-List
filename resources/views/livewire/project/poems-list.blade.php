<div class="w-full">
    <section style="animation-duration: 1s;
                animation-name: slidein;">
        @if ($poems->count())
            <main class="flex flex-wrap w-full pt-12" ">
                @foreach ($poems as $poem)
                    <article class="pb-32 px-4 w-full lg:w-1/2 xl:w-1/3">
                        @include('project.poems._single', ['poem' => $poem])
                    </article> 
                @endforeach
            </main>

            @if ($poems->hasMorePages())
                <livewire:project.load-more :poemIds="$this->poemIds" :perPage="18" :page="$page" />
            @endif
        @endif
    </section>

    <style>
        @keyframes slidein {
            from {
                margin-top: 100%;
                height: 300%; 
            }

            to {
                margin-top: 0%;
                height: 100%;
            }
        }
    </style>
</div>
