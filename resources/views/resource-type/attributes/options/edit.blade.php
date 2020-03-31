@extends ('layouts.web')

@section ('content')

<header class="flex align-left mb-8">
    <a href="{{ route('resource-types.show', $resourceType) }}" class="mx-2">
        {{ $resourceType->name }} 
    </a>

    <span class="mx-4">
        >
    </span>

    <a href="{{ route('resource-type.attributes.index', $resourceType) }}" class="mx-2">
        Attributes 
    </a>

    <span class="mx-4">
        >
    </span>

    <a href="{{ route('resource-type.attributes.edit', [$resourceType, $attribute]) }}" class="mx-2">
        {{ $attribute->name }} 
    </a>

    <span class="mx-4">
        >
    </span>

    <p class="mx-2 font-bold underline">
        {{ $option }}
    </p>
    
</header>

<main class="my-8">
    <div class="mb-24">
        <h1 class="block mb-10">
            {{ $attributeValues->count() }} total resources with value 
            <span class="font-semibold">
                {{ $option }}
            </span>
        </h1>

        {{ html()->form('PUT', route('resource-type.attribute.options.update', [$resourceType, $attribute]))->open() }}
            <label class="text-2xl flex flex-wrap">
                If you want to change this value for all the below resources, 
                do that here.

                {{ html()->text('new_option')->class('form-input w-full mt-2')
                    ->placeholder('new value') }}
            </label>

            {{ html()->hidden('option', $option) }}

            <button class="btn btn-blue mt-4">
                Change value across all resources 
            </button>
        {{ html()->form()->close() }}

    </div>


    @foreach ($attributeValues as $value)
        <a href="@route('resources.edit', $value->resource)#{{ $attribute->id }}"
            class="block mb-1 py-1 hover:bg-gray-200">
            <p class="font-semibold">
                {{ $value->resource->name }}
            </p>

            <p class="text-gray-700">
                {{ $value->value }} 
            </p>
        </a>
    @endforeach
</main>

@endsection