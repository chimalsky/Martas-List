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
        {{ $attribute->name }} 
    </p>
</header>

<header class="max-w-lg">
    {{ html()->form('PUT', route('resource-type.attributes.update', [$resourceType, $attribute]))->open() }}
        <label class="block my-2">
            <span class="text-gray-700 mb-2 w-full">Name</span>
            
            {{ html()->text("name", $attribute->name)->class(['form-input', 'mt-1', 'w-full', 'mb-2']) }}
        </label>

        <label class="block my-2">
            <span class="block">
                Type: 
            </span>
            @foreach($resourceType->availableTypes as $key => $type)
                <label class="block mb-4 cursor-pointer">
                    {{ html()->radio('type')->value($key)->checked($key === $attribute->type) }}
                    {{ $type }}
                </label>
            @endforeach
        </label>

        <button class="btn btn-blue block mt-8">
            Update 
        </button>
    {{ html()->closeModelForm() }}
</header>

@if ($attribute->type == 'dropdown')
    <section class="max-w-4xl mt-16" data-controller="resource-attribute">
        <h1> 
            Options 
        </h1>

        {{ html()->form('PUT', route('resource-type.attributes.update', [$resourceType, $attribute]))->open() }}
            {{ html()->hidden("name", $attribute->name) }}
            {{ html()->hidden("type", $attribute->type) }}

            <section class="block mt-8 mb-8" data-target="resource-attribute.options">

                @if ($attribute->options)
                    @foreach (collect($attribute->options)->sort() as $option) 
                        <a class="block text-xl mb-4 cursor-pointer"
                            href="@route('resource-type.attribute.options.edit', [
                                'resource_type' => $resourceType,
                                'attribute' => $attribute,
                                'option' => $option
                            ])">
                            {{ $option }}
                        </a>
                    @endforeach
                @else 
                    No Options for this dropdown yet
                @endif

            </section>

            <button class="btn btn-hollow mr-2" data-action="resource-attribute#addOption">
                Add another option 
            </button>
            
            <button class="btn btn-blue">
                Save Dropdown Options 
            </button>
        {{ html()->closeModelForm() }}
    </section>
@endif

<footer class="flex justify-end mt-8">
    {{ html()->form('DELETE', route('resource-type.attributes.destroy', [
        $resourceType, 
        $attribute
    ] ))->open() }}
        <div class="block flex justify-end mr-8 mb-8"
            data-controller="form">
            <button class="btn btn-red" data-action="form#delete">
                Delete this Attribute
            </button>
        </div>
    {{ html()->closeModelForm() }}
</footer>

@endsection