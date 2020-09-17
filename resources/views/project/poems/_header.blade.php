<header class="mt-8 flex flex-wrap">
    <section class="flex-shrink">
        <h1 class="text-xl -mb-3 tracking-wide flex">
            @include('project._nav')
        </h1>
    </section>

    <section class='flex-1'>
        <div class="flex justify-center space-x-4 max-w-xs mx-auto pr-10">
            <img class="object-cover w-16 h-16 rounded-full" src="{{ asset('img/do-1.jpg') }}" />
            <img class="object-cover w-16 h-16 rounded-full" src="{{ asset('img/do-2.jpg') }}" />
            <img class="object-cover w-16 h-16 rounded-full" src="{{ asset('img/do-3.png') }}" />
        </div>

        <a href="@route('project.poems.index')" class='text-2xl text-cener flex justify-center font-serif pr-12 mt-16'>
            <div>
                <span class="text-4xl">P</span>OEM 

                <span class="text-4xl">A</span>RCHIVE
            </div>
        </a>

        @routeIs('project.poems.index')
            <section class="flex justify-center space-x-4 max-w-md mx-auto mt-8">
                <div class="inline-block">
                    <img class="w-8 inline-block" src="{{ asset('img/lost-or-destroyed.png') }}" />
                    <span>
                        = manuscript lost or destroyed
                    </span>
                </div>

                <div class="inline-block">
                    <img class="w-6 inline-block" src="{{ asset('img/coming-soon.jpg') }}" />
                    <span>
                        = manuscript coming soon
                    </span>
                </div>
            </section>
        @endrouteIs
    </section>

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