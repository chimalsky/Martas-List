@extends ('resource-type._layout')

@section ('content')


<section class="max-w-2xl"
    x-data="{ open: false }">
    @foreach($resourceType->attributes as $attribute)
        <a href="{{ route('resource-type.attributes.edit', [$resourceType, $attribute]) }}"
            class="block mb-1 p-1 pl-2 flex justify-between hover:bg-gray-200">
            {{ $attribute->name }}

            ( {{ $attribute->type }} ) -- ({{ $attribute->meta_count }})
        </a>
    @endforeach

    <footer class="flex justify-end mt-4">
        <button class="btn btn-hollow"
            @click="open = true" >
            Change ordering
        </button>
    </footer>

    @include('resource-type.attributes._order-modal')
</section>

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