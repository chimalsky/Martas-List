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
        <main class="block mb-8">
            <label class="block mb-4 p-2">
                <span class="text-gray-700 mb-2 block">
                    Name
                </span>

                {{ html()->text("name")->class(['form-input', 'mt-1', 'w-1/2']) }}
            </label>


            @foreach($resourceType->availableTypes as $key => $type)
                <label class="block mb-4 cursor-pointer">
                    {{ html()->radio('type')->value($key)->checked($loop->first) }}
                    {{ $type }}
                </label>
            @endforeach
        </main>
            
        <button class="btn btn-blue">
            Add
        </button>

    {{ html()->closeModelForm() }}
</section>

@endsection