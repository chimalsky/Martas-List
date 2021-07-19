@extends ('layouts.project')

@section ('content')
<main class="max-w-2xl mx-auto text-gray-700 text-lg page-content" data-style="red">
    {!! optional(App\ResourceMeta::find(42072))->value ?? 'No content yet' !!}
</main>
@endsection