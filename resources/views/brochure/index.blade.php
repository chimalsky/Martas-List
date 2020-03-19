@extends ('layouts.brochure')

@section ('content')
<main class="justify-center flex flex-wrap ">
    <h1 class="w-full my-4 font-light text-xl text-center ">
        Dickinson's Birds -- 1863
    </h1>

    <nav class="flex flex-wrap">
        <a class="w-full my-2" href="{{ route('resource-types.index') }}">
            Archiver
        </a>

        <a class="w-full my-2" href="{{ route('project.index') }}">
            Public Archive
        </a>

        <a class="w-full my-2" href="/blog" data-turbolinks="false">
            Blog
        </a>
    </nav>
</main>

@endsection ('content')