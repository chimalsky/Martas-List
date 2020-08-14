@foreach ($birds as $key => $group)
    <h1 class="text-3xl font-bold text-gray-500 block mb-8 text-center sticky top-0 bg-white">
        {{ $key }} 
    </h1>

    <section class="flex flex-wrap">
        @foreach($group as $bird) 
            <article class="pb-32 px-4 cursor-pointer w-1/3">
                @include('project.birds._single', $bird)
            </article> 
        @endforeach
    </section>
@endforeach