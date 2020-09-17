@extends ('layouts.project')


@section ('header')
    @include('project.birds._header')
@endsection

@section ('before-content-stretch')
<header class="mb-8 ml-48">
    <h1 class="text-4xl font-hairline text-center">
        {{ $bird->firstMetaByAttribute(500)->value ?? null }}
        <span class="italic">
            ({{ $bird->firstMetaByAttribute(501)->value ?? null }})
        </span>

        | 

        <span class="italic">
            Affiliated Manuscripts
        </span>

        | 

        <a href="@route('project.birds.data', $bird)">
            Further Data
        </a>
    </h1>
</header>
@endsection

@section('content')

<main class="relative hidden xl:block ml-48">
    <img src="{{ asset('img/dale.jpg') }}" />
</main>

@endsection