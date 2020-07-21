<header class="mt-8 flex flex-wrap">
    <section class="flex-shrink">
        <h1 class="font-serif text-xl -mb-3 tracking-wide flex">
            @include('project._nav')
        </h1>
    </section>

    <section class="flex-1 flex-wrap">
        <aside class="w-full flex justify-center mb-10 -ml-24">
            <div class="h-16 w-16 bg-yellow-300 rounded-full mr-4"></div>
            <div class="h-16 w-16 bg-orange-300 rounded-full"></div>
            <div class="h-16 w-16 bg-green-400 rounded-full ml-4"></div>
        </aside>

        <section class="w-full -ml-24">
            <h1 class='flex-1 text-2xl text-center font-serif'>
                <a href="@route('project.poems.index')">
                    <span class="text-4xl">P</span>OEM <span class="text-4xl">A</span>RCHIVE
                </a>
            </h1>
        </section>
    </section>
</header>