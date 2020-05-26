@extends ('resource-type._layout')

@section ('content')

<div class="text-sm">
    {{ $resourceType->name }} category
</div>
<h1 class="text-2xl">
    {{ $category->name }}
</h1>

<ul class="mt-12">
    @foreach ($category->resources as $resource)
        <li class="mb-4">
            <a href="@route('resources.edit', $resource)" class="underline">
                {{ $resource->name }}
            </a>
        </li>
    @endforeach
</ul>


@endsection