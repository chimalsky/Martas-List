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

    <a href="{{ route('resource-types.edit', $resourceType) }}"  class="mx-2">
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
            {{ html()->select("type", [
                'default' => 'Regular attribute type -- same as tags',
                'dropdown' => 'Dropdown List',
                'rich-text' => 'Rich Text', 
                'encoding' => 'encoding',
                'link' => 'Link to another Webpage'
                ], $attribute->type)
                ->attribute('data-target', 'resource-attribute.type')
                ->attribute('data-action', 'resource-attribute#changeType')
                ->class(['form-select', 'pl-2']) }}
        </label>

        <button class="btn btn-blue block mt-8">
            Update 
        </button>
    {{ html()->closeModelForm() }}
</header>

@if ($attribute->type == 'dropdown')
    <section class="max-w-lg mt-16" data-controller="resource-attribute">
        <h1> 
            Options 
        </h1>

        {{ html()->form('PUT', route('resource-type.attributes.update', [$resourceType, $attribute]))->open() }}
            {{ html()->hidden("name", $attribute->name) }}
            {{ html()->hidden("type", $attribute->type) }}


            <section class="block mt-8 mb-8" data-target="resource-attribute.options">

                @if ($attribute->options)
                    @foreach ($attribute->options as $option) 
                        {{ html()->text('options[]', $option)->class('form-input block') }}
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
        <div class="block flex justify-end mr-8 mb-8">
            <button class="btn btn-red">
                Delete this Attribute
            </button>
        </div>
    {{ html()->closeModelForm() }}
</footer>

@endsection