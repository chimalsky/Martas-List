<header class="mt-8 flex flex-wrap">
    <section class="flex-shrink">
        <h1 class="text-xl -mb-3 tracking-wide flex">
            @include('project._nav')
        </h1>
    </section>

    <h1 class='flex-1 text-2xl text-right font-serif pr-24'>
        <a href="@route('project.poems.index')">
            <span class="text-4xl">P</span>OEM <span class="text-4xl">A</span>RCHIVE
        </a>
    </h1>

    <style>
        @keyframes slidein {
            from {
                margin-top: 100%;
                margin-left: 100%;
                height: 300%; 
                width: 100%;
            }

            to {
                margin-top: 0%;
                margin-left: 0%;
                height: 100%;
                width: 100%;
            }
        }
    </style>
</header>