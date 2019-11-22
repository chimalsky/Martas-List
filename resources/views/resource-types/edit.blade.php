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
    {{ html()->form('POST', route('resource-type.attributes.store', $resourceType))->open() }}
        <div class="flex items-end">

            <label class="w-2/3 mb-4 flex flex-wrap justify-between p-2">
                <span class="text-gray-700 mb-2 w-full">Name</span>

                {{ html()->text("name")->class(['form-input', 'mt-1', 'w-1/3']) }}

                {{ html()->select("type", [
                    'default' => 'Regular attribute type -- same as tags',
                    'dropdown' => 'Dropdown List',
                    'rich-text' => 'Rich Text', 
                    'encoding' => 'encoding',
                    'link' => 'Link to another Webpage'
                    ])
                    ->class(['form-select', 'pl-2', 'w-1/3']) }}
            </label>
        </div>
        
        <button class="btn btn-blue">
            Add new Attribute
        </button>

    {{ html()->closeModelForm() }}
</section>

<section class="flex flex-wrap bg-gray-200">
    <h1 class="font-semibold mt-8 w-full m-2">
        Existing Attributes: 
    </h1>

    @foreach($resourceType->attributes as $attribute)
        <div class="w-1/2 p-4 border border-4 border-gray-400"
            data-controller="resource-attribute">
            {{ html()->form('PUT', route('resource-type.attributes.update', ['resource-type' => $resourceType, 'attribute' => $attribute]))->open() }}
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

                <label data-target="resource-attribute.options" class="hidden block mt-8 mb-3">
                    <span class="block">
                        Options
                    </span>

                    @if ($attribute->options)
                        @foreach ($attribute->options as $option) 
                            {{ html()->text('options[]', $option)->class('form-input block') }}
                        @endforeach
                    @endif

                </label>

                <button class="btn btn-hollow" data-action="resource-attribute#addOption">
                    Add another option 
                </button>

                <button class="btn btn-blue block mt-2">
                    Update 
                </button>
            {{ html()->closeModelForm() }}

            
            {{ html()->form('DELETE', route('resource-type.attributes.destroy', [
                'resource-type' => $resourceType, 
                'attribute' => $attribute
            ] ))->open() }}
                <div class="block flex justify-end mr-8 mb-8">
                    <button class="btn btn-red">
                        Remove
                    </button>
                </div>
            {{ html()->closeModelForm() }}
        </div>

    @endforeach
    
</section>


<section class="p-4 my-4 bg-indigo-200">
    <h1 class="font-semibold">
        Connections to other resources
    </h1>

    {{ html()->form('PUT', route('resource-type.connections.update', $resourceType))->open() }}
        <div class="">
            @foreach (\App\ResourceType::all() as $rt)
                <label class="block mb-4 p-2">
                    <input type="checkbox" name="resourceTypeConnections[]" value="{{ $rt->id }}"
                        @if ( $resourceType->connections->pluck('key')->contains($rt->id) )
                            checked
                        @endif />
                    {{  $rt->name }} 
                </label>
            @endforeach
        </div>
        
        <button class="btn btn-blue">
            Save Changes
        </button>

    {{ html()->closeModelForm() }}

</section>


@endsection