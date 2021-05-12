@extends ('layouts.project-shifted')

@section('title')
    {{ $bird->name }} - Data Source - Dickinson's Birds
@endsection

@section('header-anchor')
<a href="@route('project.birds.index')">
    Bird Archive
</a>
@endsection 

@section ('header-info')
    @include('project.birds._header')
@endsection

@section ('before-content-stretch')
<header class="mb-8 ml-48">
    <h1 class="text-4xl font-hairline text-center">
        <a href="@route('project.birds.show', $bird)">
            {{ $bird->firstMetaByAttribute(500)->value ?? null }}
            <span class="italic">
                ({{ $bird->firstMetaByAttribute(501)->value ?? null }})
            </span>
        </a>

        | 

        <span class="italic">
            Affiliated Manuscripts
        </span>

        | 

        <a href="@route('project.birds.data', $bird)" class="font-bold">
            Further Data
        </a>
    </h1>
</header>
@endsection

@section('content')

<main class="relative max-w-3xl mx-auto flex flex-wrap pl-40">
    <section class="w-2/5">
        <img class="w-64 mt-8 object-scale-down" src="{{ asset('img/dale.jpg') }}" />
    </section>

    <section class="w-3/5">
        <h1 class="text-3xl italic">
            Bird Lists 
        </h1>

        <ul class="text-xl space-y-4">
            @foreach ($birdLists as $birdList)
                <li x-data="{expanded: false}" @click="expanded = !expanded" 
                    class="ml-6">
                    <p class="underline cursor-pointer">
                        {{ $birdList->name }}
                    </p>
                    @php 
                        $otherBird = $bird->resources->firstWhere('resource_type_id', $birdList->id);
                        $attributes = $birdList->attributes->where('visibility', 1);
                    @endphp 
                    <aside x-show="expanded" x-on:click.stop>
                        <ul class="pl-8">
                            @foreach($attributes as $attribute) 
                                @php 
                                    $otherBirdMeta = $otherBird->firstMetaByAttribute($attribute) ?? null;
                                @endphp

                                @if ($otherBirdMeta)
                                    <li class="mb-4">
                                        <span class="italic text-xm mr-2">
                                            {{ $attribute->name }}
                                        </span>

                                        {{ $otherBirdMeta->value }}
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </aside>
                </li>
            @endforeach
        </ul>
    </section>
</main>

@endsection