@extends ('resource-type._layout')

@section ('content')


{{ html()->form('put', route('resource-type.attributes.sort', $resourceType))->open() }}
    <section class="sortable max-w-2xl">
        <h1 class="font-semibold mb-4 block">
            Existing Attributes: 
        </h1>

        @foreach($resourceType->attributes as $attribute)
            <article class="block mb-2 p-1 flex justify-between cursor-move">
                {{ $attribute->name }}

                ( {{ $attribute->type }} )

                <input type="hidden" name="attributes[]" value="{{ $attribute->id }}" />

                <a class="btn btn-gray" href="{{ route('resource-type.attributes.edit', [$resourceType, $attribute]) }}">
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

@endsection