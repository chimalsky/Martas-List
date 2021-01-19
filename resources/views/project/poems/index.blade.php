@extends ('layouts.project-shifted')

@section('header-anchor')
<a href="@route('project.poems.index')">
    Poem Archive
</a>
@endsection 

@section('header-info')

<x-project.poem.state />

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
<livewire:project.poem.filter />
@endsection


@section ('content')
    <livewire:project.poem.index />
@endsection