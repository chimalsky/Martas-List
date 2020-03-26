@extends ('layouts.project')

@section ('content')
<section class="container mx-auto">
    <header class="mt-12 max-w-2xl">
        <h1 class="font-serif text-4xl text-yellow-700 -mb-3 tracking-wide flex">
            @include('project._nav')
        </h1>
        <h1 class="font-serif text-4xl tracking-wide italic">
            A Public Listening Project 
        </h1>

        <h2 class="mt-4 text-gray-700 text-lg tracking-wide">
            Edited by Marta Werner, <br/>
            with Abraham Kim and Caroline McCraw
        </h2>
    </header>

    <main class="block my-12 max-w-2xl mx-auto">
        <img src="{{ asset('img/map-ma.png') }}" />
    </main>
</section>

   
<script>
    let toggle = document.querySelector('#menu-toggle')

    demoToggle(800)
    demoToggle(1400)
    demoToggle(2000)
    demoToggle(2800)

    
    function demoToggle(delay) {
        setTimeout(function() {
            toggle.click()
        }, delay)
    }
</script>

@endsection