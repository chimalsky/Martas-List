<section class="flex flex-wrap">
    @foreach ($birds as $bird)
        <article class="pb-32 px-4 w-full lg:w-1/2 xl:w-1/3">
            @include('project.birds._single', ['bird' => $bird])
        </article> 
    @endforeach
</section>
