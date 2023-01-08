<main class="flex flex-wrap w-full pt-12">
    @foreach ($poems as $poem)
        <article class="pb-32 px-4 w-full lg:w-1/2 xl:w-1/3">
            @include('project.poems._single', ['poem' => $poem, 'attributeOrder' => $attributeOrder])
        </article> 
    @endforeach
</main>

