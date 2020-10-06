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
<section class="flex justify-center space-x-4 max-w-lg mx-auto mt-8 text-lg">
    <div class="inline-block">
        <img class="w-8 inline-block" src="{{ asset('img/lost-or-destroyed.png') }}" />
        <span>
            = manuscript lost or destroyed
        </span>
    </div>

    <div class="inline-block">
        <img class="w-5 inline-block" src="{{ asset('img/coming-soon.jpg') }}" />
        <span>
            = manuscript coming soon
        </span>
    </div>
</section>

<x-project.archive-notes contentId="42072">
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