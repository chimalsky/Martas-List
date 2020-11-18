@extends ('layouts.project-shifted')

@section('header-anchor')
<a href="@route('project.poems.index')" class=''>
    <div>
        <span class="text-4xl">P</span>OEM 

        <span class="text-4xl">A</span>RCHIVE
    </div>
</a>
@endsection 

@section('header-info')

<x-project.poem.state />

<x-project.archive-notes contentId="42072">
</x-project.archive-notes>

<x-notification.toaster on="poem.filter:updated">
    updating
</x-notification.toaster>
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