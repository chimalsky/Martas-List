@extends('resource-type._layout')

@section('content')

<h1 class="text-xl mb-6">
    Changelog for {{ $type }}
</h1>

<nav class="inline-block mb-8">
    <a href="{{ route('resource-type.activities.index', ['resource_type' => $resourceType, 'type' => 'resource_meta']) }}"
        class="border mx-2 p-4 border-gray-500 @if ($type == 'resource_meta') font-bold bg-gray-300 @endif">
        Meta
    </a>
    <a href="{{ route('resource-type.activities.index', ['resource_type' => $resourceType, 'type' => 'resource_media']) }}"
        class="border mx-2 p-4 border-gray-500 @if ($type == 'resource_media') font-bold bg-gray-300 @endif">
        Media
    </a>
</nav>

@include('resource-type.activities.'.$type, ['activities' => $activities])

@endsection