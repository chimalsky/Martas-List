@extends ('layouts.web')

@section('content')

<section class="block my-8 sortable">
    @foreach ($attribute->options as $option)
        <article class="block mb-4">
            {{ $option }}
        </article>
    @endforeach
</section> 

@endsection