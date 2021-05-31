@extends ('layouts.project-shifted')

@section('title')
    Poem Archive - Dickinson's Birds
@endsection

@push('controllers')
    archive
@endpush

@section('header-anchor')
<a href="@route('project.poems.index')">
    Poem Archive
</a>
@endsection 

@section('header-info')

<x-project.archive-notes title="Poem">
    <x-slot name="content">
        @php
            $content = optional(App\ResourceMeta::find(42072))->value ?? 'No content yet';
        @endphp

        {!! $content !!}
    </x-slot>
</x-project.archive-notes>

@endsection

@section('sticky-aside')

<form id="js-main-form" data-target="archive.form" data-controller="form" action="@route('project.poems.index')" method="get">
    <input placeholder="Transcription text search..." name="query" data-action="input->form#changed"
        @if (request()->input('query')) value="{{ request()->input('query') }}" @endif
        class="block mb-4 border-4 border-gray-700 text-black rounded-full pl-4 p-2 placeholder-gray-800" />

    <div class="flex justify-between items-stretch w-full">
        <label class="cursor-pointer p-2 self-center">
            Sorted by
            <select name="sortable" data-action="change->form#changed">
                <option value="firstline">
                    First Line
                </option>
                <option value="year">
                    Year
                </option>
            </select>
        </label>

        <label class="cursor-pointer self-center">
            <select name="sort_direction" data-action="change->form#changed"> 
                <option value="asc">
                    Forward
                </option>
                <option value="desc">
                    Reverse
                </option>
            </select>
        </label>
    </div>


    @foreach(App\ResourceType::find(App\Project\Poem::resource_type_id)->attributes->where('visibility', 1) as $key => $filterable)
        @if ($loop->index === 3) 
            <section class="block mb-1" x-data="{open: false}">
                <button type="button" @click="open = !open"
                    class="p-1 flex justify-between items-stretch w-full">
                    <span class="self-center" :class="{ 'font-black': open }">
                        Birds
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
                        <x-project.filter.dickinsons-birds :dickinsonsBirds="$birds" />
                    </div>
                </div>
            </section>
        @endif

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
</form>
@endsection


@section ('content')
<section id="results-section">
    @include('project.poems.results', ['results' => $results])
</section>
@endsection