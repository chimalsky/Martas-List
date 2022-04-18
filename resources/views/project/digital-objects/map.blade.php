@extends ('layouts.project-digital-objects')

@section ('content')
<main class="max-w-2xl mx-auto text-gray-700 text-lg page-content text-center my-32" data-style="red">
    {!! optional(App\ResourceMeta::find(46378))->value ?? 'No content yet' !!}
</main>
@endsection