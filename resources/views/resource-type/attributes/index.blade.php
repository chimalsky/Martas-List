@extends ('resource-type._layout')

@section ('content')


<section class="max-w-2xl"
    x-data="{ open: false }">
    @foreach($resourceType->attributes as $attribute)
        <a href="{{ route('resource-type.attributes.edit', [$resourceType, $attribute]) }}"
            class="block mb-1 py-2 pl-3
                @if($attribute->visibility) font-bold @endif">
            {{ $attribute->title }} 
            <span class="italic ml-2">
                {{ $attribute->subtitle }}
            </span>
            <span class="font-mono">
            ( {{ $attribute->type }} )
            </span> -- ({{ $attribute->meta_count }})
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

<section class="p-4 mt-24">
    <h1 class="text-xl font-thin"> 
        Add a new Attribute 
    </h1>

    {{ html()->form('POST', route('resource-type.attributes.store', $resourceType))->open() }}
        <main class="block mb-8">
            <label class="block mb-4 p-2">
                <span class="mb-2 block">
                    Title
                </span>

                {{ html()->text("title")->class(['form-input', 'mt-1', 'w-1/2']) }}
            </label>

            <label class="block mb-4 p-2">
                <span class="mb-2 block">
                    Subtitle
                </span>

                {{ html()->text("subtitle")->class(['form-input', 'mt-1', 'w-1/2']) }}
            </label>


            @foreach($resourceType->availableTypes as $key => $type)
                <label class="block mb-4 cursor-pointer">
                    {{ html()->radio('type')->value($key)->checked($loop->first) }}
                    {{ $type }}
                </label>
            @endforeach

            <section class="block my-8">
                <header class="font-semibold mb-2">
                    Visibility 
                </header> 

                <div class="flex items-center my-3">
                    <input id="visibility_public" name="visibility" value="1"
                        type="radio" class="form-radio h-4 w-4 transition duration-150 ease-in-out" />
                    <label for="visibility_public" class="ml-3">
                        <span class="block text-sm leading-5 font-medium ">Public and Searchable</span>
                    </label>
                </div>

                <div class="flex items-center my-3">
                    <input id="visibility_private" name="visibility" value="0" checked
                        type="radio" class="form-radio h-4 w-4 transition duration-150 ease-in-out" />
                    <label for="visibility_private" class="ml-3">
                        <span class="block text-sm leading-5 font-medium ">Private</span>
                    </label>
                </div>
            </section>
        </main>
            
        <button class="btn btn-blue">
            Add
        </button>

    {{ html()->closeModelForm() }}
</section>

@endsection