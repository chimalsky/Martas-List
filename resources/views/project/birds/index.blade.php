@extends ('layouts.project')


@section ('header')
    @include('project._nav')
@endsection

@section ('content')
<section class="flex flex-wrap justify-center">
    <aside class="pr-6 hidden md:inline-flex md:w-64">
        <div x-data="">
            <div class="mt-1 relative rounded-md shadow-sm" @click="alert('coming soon. please call your congressperson to get this working!!')">
                <input id="account_number" class="form-input block w-full pr-10 sm:text-sm sm:leading-5 rounded-lg" placeholder="search..." />
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>
        </div>
    </aside>
        
    <main class="flex-1 text-gray-700 text-lg">
        <header class="text-center text-2xl block mb-16">
            Bird Archive 
        </header>

        <section class="flex flex-wrap items-start">
            @foreach ($birds as $bird)
                <article class="w-full lg:w-1/2 xl:w-1/3 pb-24 px-2">
                    @include('project.birds._single', $bird)
                </article> 
            @endforeach
        </section>
    </main>
</section>
@endsection