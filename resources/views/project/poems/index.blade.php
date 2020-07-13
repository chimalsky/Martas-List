@extends ('layouts.project')


@section ('header')
    @include('project.poems._header')
@endsection

@section ('content')

@livewire('project.poems-index')
                
<script>    
    const form = document.querySelector('#js-filter-form')

    function fetchPoems() {
        let formdata = new FormData(form)

        fetch('/project/poems/get', {
            method: 'post',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formdata
        })
            .then(response => response.text())
            .then(html => {
                document.querySelector('#js-poems-list').innerHTML = html
            })
    }
</script>

@endsection