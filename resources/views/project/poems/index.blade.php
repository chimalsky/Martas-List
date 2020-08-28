@extends ('layouts.project')


@section ('header')
    <header class="">
        @include('project.poems._header')
    </header>
@endsection

@section ('content')
    <livewire:project.poems-index />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.livewire.on('poems-list.end', function(page) {
                let curationDetails = document.querySelector('#js-show-at-end-of-list');

                //curationDetails.classList.remove('hidden');
            })
        });
    </script>
@endsection