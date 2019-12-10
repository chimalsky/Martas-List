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

{{ html()->form('put', route('resource-type.attributes.sort', $resourceType))->open() }}
    <section class="sortable">
        <h1 class="font-semibold mb-4 block">
            Existing Attributes: 
        </h1>

        @foreach($resourceType->attributes as $attribute)
            <article class="block mb-2 p-1 flex justify-between">
                {{ $attribute->name }}

                <input type="hidden" name="attributes[]" value="{{ $attribute->id }}" />

                <a class="btn btn-gray" href="{{ route('resource-type.attributes.edit', ['resource-type' => $resourceType, 'attribute' => $attribute]) }}">
                    Edit 
                </a>
            </article>
        @endforeach
    </section>

    <button class="btn btn-blue mt-12">
        Save changes to Attributes Ordering
    </button>
{{ html()->form()->close() }}

<section class="p-4 mt-24 bg-gray-300">
    <h1> 
        Add a new Attribute 
    </h1>

    {{ html()->form('POST', route('resource-type.attributes.store', $resourceType))->open() }}
        <div class="flex items-end">
            <label class="w-2/3 mb-4 flex flex-wrap justify-between p-2">
                <span class="text-gray-700 mb-2 w-full">Name</span>

                {{ html()->text("name")->class(['form-input', 'mt-1', 'w-1/2']) }}

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
            Add
        </button>

    {{ html()->closeModelForm() }}
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