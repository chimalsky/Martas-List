@extends ('layouts.web')

@section ('content')

<header class="flex align-left mb-8">
    <a href="{{ route('resource-types.index') }}">
        Resources
    </a>

    <span class="mx-4">
        >
    </span>

    <a href="{{ route('resource-types.show', $resourceType) }}" class="mx-2">
        {{ $resourceType->name }} 
    </a>

    <span class="mx-4">
        >
    </span>

    <p class="mx-2 font-bold underline">
        Editing {{ $resourceType->name }} 
    </p>
</header>

{{ html()->form('put', route('resource-type.attributes.sort', $resourceType))->open() }}
    <section class="sortable">
        <h1 class="font-semibold mb-4 block">
            Existing Attributes: 
        </h1>

        @foreach($resourceType->attributes as $attribute)
            <article class="block mb-2 p-1">
                {{ $attribute->name }}

                <input type="hidden" name="attributes[]" value="{{ $attribute->id }}" />
            </article>
        @endforeach
    </section>

    <button class="btn btn-blue mt-16">
        Save This Order 
    </button>
{{ html()->form()->close() }}



@endsection