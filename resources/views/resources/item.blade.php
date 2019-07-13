<article class="w-full md:w-1/2 lg:w-1/3 p-2">
    <div class="m4 p-4 border border-2 border-gray-900">
        <a href="{{ route('resources.edit', $resource) }}">
            <h1 class="font-semibold text-xl">
                {{ $resource->name }}
            </h1>
        </a>

        <aside class="w-full mt-2">
            <section class="italic">
                {!! $resource->excerpt !!}
            </section>
            
            <section class="bg-gray-200 p-2">
                @include('resource.connections.panel', ['resource' => $resource])
            </section>
        </aside>
    </div>
</article>
