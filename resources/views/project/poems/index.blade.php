@extends ('layouts.project')


@section ('header')
    @include('project._nav')
@endsection

@section ('content')
<section class="flex flex-wrap justify-center">
    <aside class="w-64 pr-6">
        <form action="@route('project.poems.index')" method="get">
            <div x-data="" class="mt-1 relative rounded-md shadow-sm">
                <input name="query" @click="alert('coming soon. please call your congressperson to get this working!!')"
                    class="form-input block w-full pr-10 sm:text-sm sm:leading-5 rounded-lg" 
                    placeholder="search..." />
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </form>
    </aside>

    <main class="flex-1 text-gray-700 text-lg">
        <header class="text-center text-2xl block mb-32">
            Poem Archive 
        </header> 

        <section class="flex flex-wrap">
            @foreach ($poems as $poem)
                <article class="pb-32 px-4 cursor-pointer w-1/3">
                    @include('project.poems._single', $poem)
                </article> 
            @endforeach
        </section>
    </main>
</section>

@endsection