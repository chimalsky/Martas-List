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

        <a href="@route('project.birds.index')" class='text-2xl text-cener flex justify-center font-serif pr-12 mt-16'>
            <div>
                <span class="text-4xl">B</span>IRD 

                <span class="text-4xl">A</span>RCHIVE
            </div>
        </a>
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