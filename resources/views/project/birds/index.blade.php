@extends ('layouts.project-shifted')

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
<livewire:project.bird.filter />
@endsection

@section ('content')

<div>
    <livewire:project.bird.index />
</div>


@endsection