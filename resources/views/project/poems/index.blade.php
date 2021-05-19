@extends ('layouts.project-shifted')

@section('title')
    Poem Archive - Dickinson's Birds
@endsection

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

<form data-controller="form" action="@route('project.poems.index')" method="get">
    <input placeholder="search by transcription text..." name="query" data-action="input->form#changed"
        class="block mb-4 border-4 border-gray-700 text-black rounded-full pl-4 p-2 placeholder-gray-800" />

    <button>
        Sort by First Line
    </button>


    @foreach(App\ResourceType::find(App\Project\Poem::resource_type_id)->attributes->where('visibility', 1) as $key => $filterable)
        @unless($filterable->id == 370)
        <section class="block my-6" x-data="{open: false}">
            @php 
                // Only expand the first two Filterables
                $expanded = $key < 2;
            @endphp

            <button type="button" @click="open = !open"
                class="p-1 flex justify-between items-stretch w-full">
                <span class="self-center">
                    {{ $filterable->key }} 
                </span>
                <span class="text-2xl self-center">
                    +
                </span>
            </button>

            <div x-show="open" class="w-full h-32 overflow-y-auto pl-6">
                @foreach ($filterable->options as $option)
                    <label class="block cursor-pointer">
                        <input data-action="change->form#changed" type="checkbox"
                            name="filterable[{{ $filterable->id }}][]"
                            value="{{ $option }}"
                            class=""
                            @if (collect(request()->input('filterable.' . $filterable->id))->contains($option))
                                checked 
                            @endif
                            autocomplete="off" 
                                />
                        <span class="pl-2">
                            {{ $option }}
                        </span>
                    </label>
                @endforeach
            </div>
        </section>
        @endunless
    @endforeach
</form>
@endsection


@section ('content')
<section id="results-section">
    @include('project.poems.results', ['poems' => $poems])
</section>
@endsection