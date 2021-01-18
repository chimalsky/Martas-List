@extends ('layouts.project-shifted')

@section('header-anchor')
<a href="@route('project.poems.index')">
    Poem Archive
</a>
@endsection 

@section('header-info')

<x-project.poem.state />

<x-project.archive-notes title="Poem" contentId="42072">
</x-project.archive-notes>

@endsection

@section('sticky-aside')
<livewire:project.poem.filter />
@endsection


@section ('content')
    <livewire:project.poem.index />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.livewire.on('poems-list.end', function(page) {
                let curationDetails = document.querySelector('#js-show-at-end-of-list');

                //curationDetails.classList.remove('hidden');
            })
        });
    </script>
@endsection