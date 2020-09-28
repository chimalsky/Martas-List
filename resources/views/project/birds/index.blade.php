@extends ('layouts.project-shifted')

@section('header-anchor')
<a href="@route('project.birds.index')" class=''>
    <div>
        <span class="text-4xl">B</span>IRD 

        <span class="text-4xl">A</span>RCHIVE
    </div>
</a>
@endsection 

@section('header-info')
<x-project.archive-notes>
    <article>
        +  For information on the guiding editorial principles for the Poem Archive, see 
        <a href="">
            Introduction.
        </a>
    </article>
    <article>
        +  For details about sources, see 
        <a href="">
            Primary Sources.
        </a>
    </article>

    <h1>
        Sources
    </h1>
    <h2 class="italic">
        Citations for Dickinson’s birds come from— 
    </h2>
</x-project.archive-notes>
@endsection

@section('sticky-aside')
<livewire:project.bird.filter />
@endsection

@section ('content')

<div>
    <livewire:project.bird.index />
</div>


@if(false)

            
<script>    
    function fetchBirds() {
        fetch('/project/partials/birds', {
            method: 'get',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
            .then(response => response.text())
            .then(html => {
                document.querySelector('#birds-list').innerHTML = html
            })
    }
</script>

<section class="flex flex-wrap justify-center">
    <aside class="pr-6 hidden md:inline-flex md:w-64">
        <form action="@route('project.birds.index')" method="GET">
            <select name="query_key"
                class="mb-3 pl-2 w-full">
                @foreach ($birdDefinition->attributes as $attribute)
                    <option value="{{ $attribute->id }}" >
                        {{ $attribute->name }}
                    </option>
                @endforeach
            </select>

            <div x-data="" class="mt-1 flex">
                <input name="query_value"
                    class="form-input flex-1 pr-10 mr-2 sm:text-sm sm:leading-5 rounded-lg relative shadow-sm" 
                    placeholder="search..." />
                <button class="p-2 rounded-lg hover:bg-gray-500 cursor-pointer bg-gray-700 pr-3 flex-1 items-center">
                    <svg class="h-5 w-5 text-gray-200" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12.9 14.32a8 8 0 1 1 1.41-1.41l5.35 5.33-1.42 1.42-5.33-5.34zM8 14A6 6 0 1 0 8 2a6 6 0 0 0 0 12z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            @if ($queries->count())
            <section class="mt-4 px-2">
                @foreach ($queries as $query)
                    <input type="hidden" name="queries_key[]" 
                        value="$query->query" />
                    <input type="hidden" name="queries_values[]" 
                        value="{{ $query->attribute->id }}" />

                    <div class="block">
                        {{ $query->attribute->name }} :
                        <span class="p-2 bg-red-200">
                            {{ $query->query }}
                        </span>
                    </div>
                @endforeach
            </section>
            @endif
        </form>
    </aside>
        
    <main class="flex-1 text-gray-700 text-lg">
        <header class="text-center text-2xl block mb-16">
            Bird Archive 


            @if (!$birds->count())
                <h1 class="text-center text-lg mt-4">
                    No Birds matching your search 
                </h1>
            @endif
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
@endif
@endsection