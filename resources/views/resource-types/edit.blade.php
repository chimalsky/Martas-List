@extends ('layouts.web')

@section ('content')

<header class="flex align-left mb-8">
    <a href="{{ route('resources.index') }}">
        Archiver Main Page
    </a>

    <span class="mx-4">
        >
    </span>

    <a href="{{ route('resource-types.index') }}">
        Resources
    </a>

    <span class="mx-4">
        >
    </span>

    <a href="{{ route('resource-types.edit', $resourceType) }}" class="mx-2 font-bold underline">
        {{ $resourceType->name }} 
    </a>
</header>


<section class="flex flex-wrap mb-8">
    {{ html()->modelForm($resourceType, 'PUT', route('resource-types.update', $resourceType))->open() }}
        @include('resource-types.form')

        <footer class="py-4">
            <button class="btn btn-hollow">
                Save changes to this Resource Type 
            </button>
        </footer>
    {{ html()->closeModelForm() }}
</section>


<section class="p-4 my-4 bg-gray-300">
    <h1 class="font-semibold">
        Main Attributes
    </h1>

    {{ html()->form('POST', route('resource-type.attributes.store', $resourceType))->open() }}
        <div class="flex items-end">

            <label class="w-2/3 mb-4 flex flex-wrap justify-between p-2">
                <span class="text-gray-700 mb-2 w-full">Name</span>

                {{ html()->text("name")->class(['form-input', 'mt-1', 'w-1/3']) }}

                {{ html()->select("type", [
                    null => 'Regular attribute type -- same as tags',
                    'rich-text' => 'Rich Text', 
                    'encoding' => 'encoding',
                    'temporality' => 'Temporality'
                    ])
                    ->class(['form-select', 'pl-2', 'w-1/3']) }}
            </label>
        </div>
        
        <button class="btn btn-blue">
            Add new Attribute
        </button>

    {{ html()->closeModelForm() }}

    <h1 class="font-semibold mt-8">
        Existing Attributes: 
    </h1>

    @foreach($resourceType->mainAttributes as $attribute)
        {{ html()->form('PUT', route('resource-type.attributes.update', ['resource-type' => $resourceType, 'attribute' => $attribute->name]))->open() }}
            <label class="w-1/2 mb-4 flex flex-wrap justify-between border border-4 border-gray-400 p-2">
                <span class="text-gray-700 mb-2 w-full">Name</span>

                {{ html()->text("name", $attribute->name)->class(['form-input', 'mt-1', 'w-1/3']) }}

                {{ html()->select("type", [
                    null => 'Regular attribute type -- same as tags',
                    'rich-text' => 'Rich Text', 
                    'encoding' => 'encoding',
                    'temporality' => 'Temporality'
                    ], $attribute->type)
                    ->class(['form-select', 'pl-2', 'w-1/3']) }}
            </label>

            <button class="btn btn-blue">
                Update 
            </button>
        {{ html()->closeModelForm() }}

        
        {{ html()->form('DELETE', route('resource-type.attributes.destroy', [
            'resource-type' => $resourceType, 
            'attribute' => $attribute->name
        ] ))->open() }}
            <div class="flex justify-end mr-4 mt-4">
                <button class="btn btn-red">
                    Remove
                </button>
            </div>
        {{ html()->closeModelForm() }}

    @endforeach

    
</section>


<section class="border border-1 border-red-900 p-4 mb-4">
    <h1 class="text-xl">
        Add a new {{ $resourceType->nameSingular }} 
    </h1>

    {{ html()->form('POST', route('resources.store'))->open() }}
        @include('resources.form', ['resourceType' => $resourceType])
        
        <button class="btn btn-blue my-2">
            Add a new {{ $resourceType->nameSingular }} resource
        </button>
    {{ html()->form()->close() }}
</section>

@if($resourceType->resources->count())
    <h1 class="text-xl">
        {{ $resourceType->name }} resources: 
    </h1>

    <section class="flex flex-wrap my-2">
        @foreach($resourceType->resources as $resource)
            @include('resources.item', ['resource' => $resource])
        @endforeach 
    </section>
@else 
    <h1 class="text-xl">
        No {{ $resourceType->name }} yet...  
    </h1>
@endif

@endsection