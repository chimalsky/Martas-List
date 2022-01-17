@extends ('layouts.project-shifted')

@section('title')
    Bird Archive - Dickinson's Birds
@endsection

@push('stimulus-controllers')
    archive
@endpush

@push('stimulus-attributes')
    data-action="form-updated@window->archive#loading 
        form-submitted@window->archive#loading 
        results-updating@window->archive#loadingComplete"
@endpush

@section('header-anchor')
<a href="@route('project.birds.index')">
    Bird Archive
</a>
@endsection 

@section('header-info')

<x-project.archive-notes title="Bird">
    <x-slot name="content">
        @php
            $content = optional(App\ResourceMeta::find(42073))->value ?? 'No content yet';
        @endphp

        {!! $content !!}
    </x-slot>

    <x-slot name="footnotes">
        @php
            $footnotes = optional(App\ResourceMeta::find(45230))->value ?? 'No content yet';
        @endphp

        {!! $footnotes !!}
    </x-slot>
</x-project.archive-notes>

@endsection

@section('sticky-aside')

<form id="js-main-form" data-target="archive.form" data-controller="form" 
    data-action="filter-value-updated@window->form#changed 
        curation-cleared@window->form#clearState
        query-cleared@window->form#clearQuery" 
    action="@route('project.birds.index-fetch')" method="get">
    <input placeholder="Search bird species" name="query" data-action="input->form#changed"
        @if (request()->input('query')) value="{{ request()->input('query') }}" @endif
        class="block mb-4 border-4 border-gray-500 text-black rounded-full pl-4 p-2 placeholder-gray-800" />
    
    <label class="cursor-pointer p-1 self-center text-xs py-2">
        Sorted by: <span class="font-bold">Bird Name</span>

        <select name="sort_direction" data-action="change->form#changed"> 
            <option value="asc">
                Ascending
            </option>
            <option value="desc">
                Descending
            </option>
        </select>
     </label>

    <div class="mt-4">
        @foreach(App\ResourceType::find(App\Project\Bird::$resource_type_id)->attributes->where('visibility', 1) as $key => $filterable)
            <section class="block mb-1" x-data="{open: false}">
                <button type="button" @click="open = !open"
                    class="p-1 flex justify-between items-stretch w-full">
                    <span class="self-center" :class="{ 'font-black': open }">
                        {{ $filterable->title }} 
                    </span>
                    <span class="text-3xl self-center">
                        <span x-show="!open">
                            +
                        </span>
                        <span x-show="open">
                            -
                        </span>
                    </span>
                </button>

                <div x-show="open" class="w-full">
                    <div class="text-gray-600 italic mb-2">
                        {{ $filterable->subtitle }} 
                    </div>

                    <div class="pl-6 overflow-y-scroll" style="max-height: 8rem;">
                        <x-project.filter.panel :filterable="$filterable" />
                    </div>
                </div>
            </section>
        @endforeach
    </div>

    @php
        $activeSeasons = collect([]);
        $activeMonths = collect([]);
        $activeChrono = null;
        $activeChronoScope = 'seasons';
    @endphp 

    <section class="block mb-1" x-data="{open: false}">
        <button type="button" @click="open = !open"
            class="p-1 flex justify-between items-stretch w-full">
            <span class="self-center" :class="{ 'font-black': open }">
                Presence
            </span>
            <span class="text-3xl self-center">
                <span x-show="!open">
                    +
                </span>
                <span x-show="open">
                    -
                </span>
            </span>
        </button>

        <div x-show="open" class="w-full overflow-y-auto">
            <x-project.filter.presence :activeSeasons="$activeSeasons" 
                :activeMonths="$activeMonths" :activeChrono="$activeChrono"
                :activeChronoScope="$activeChronoScope" />
        </div>
    </section>

    <section class="block mb-1" x-data="{open: false}">
        <button type="button" @click="open = !open"
            class="p-1 flex justify-between items-stretch w-full">
            <span class="self-center" :class="{ 'font-black': open }">
                Dickinson's Bird List
            </span>
            <span class="text-3xl self-center">
                <span x-show="!open">
                    +
                </span>
                <span x-show="open">
                    -
                </span>
            </span>
        </button>

        <div x-show="open" class="w-full overflow-y-auto">
            <div class="text-gray-600 italic mb-2">
                Birds referenced
            </div>
            <div class="overflow-y" style="max-height: 10rem;">
                <x-project.filter.dickinsons-birds />
            </div>
        </div>
    </section>
</form>

<script>
    document.querySelector('#js-main-form').addEventListener('keydown', function(event) {
        if (event.key === "Enter") {
            if (event.target.type !== 'submit') {
                event.preventDefault();
                return false;
            }
        }
    })
</script>
@endsection

@section ('content')
<main data-archive-target="resultsContainer" class="pb-24">
    <div class="loading-splash">
        <div class="animate-ping h-12 w-12 hover:text-gray-500 focus:outline-none 
            focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 
            transition ease-in-out duration-150 mt-16 mx-auto">
            <img src="{{ asset('img/bird-icon-round.png') }}" />
        </div>

        <p class="text-center mt-8 text-lg text-gray-600" data-archive-target="hide">
            Loading a world of Birds
        </p>
    </div>

    <section data-archive-target="results" data-action="results-updating@window->archive#replaceResults"">
    </section>
</main>
@endsection