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

    <a href="{{ route('resource-type.attributes.index', $resourceType) }}" class="mx-2">
        Attributes 
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
            <span class="mb-2 w-full">Name</span>
            
            {{ html()->text("name", $attribute->name)->class(['form-input', 'mt-1', 'w-full', 'mb-2']) }}
        </label>

        <label class="block my-2">
            <span class="block">
                Type: 
            </span>

            {{ html()->select("type", $resourceType->availableTypes, $attribute->type)
                ->class(['attribute', 'form-dropdown', 'form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}
        </label>

        <section class="block my-8">
            <header class="font-semibold mb-2">
                Visibility 
            </header> 

            <div class="flex items-center my-3">
                <input id="visibility_public" name="visibility" value="1"
                    @if ($attribute->visibility) checked @endif
                    type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                <label for="visibility_public" class="ml-3">
                    <span class="block text-sm leading-5 font-medium">Public and Searchable</span>
                </label>
            </div>

            <div class="flex items-center my-3">
                <input id="visibility_private" name="visibility" value="0"
                    @unless ($attribute->visibility) checked @endunless
                    type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out" />
                <label for="visibility_private" class="ml-3">
                    <span class="block text-sm leading-5 font-mediumeeq">Private</span>
                </label>
            </div>
        </section>
        
        <button class="btn btn-blue block mt-8">
            Update 
        </button>
    {{ html()->closeModelForm() }}
</header>

@if ($attribute->type == 'dropdown')
    <section class="max-w-4xl mt-24" data-controller="resource-attribute"
        x-data="{ open: false }">
        <header class="flex justify-between items-center">
            <h1 class="text-3xl text-gray-500"> 
                Options 
            </h1>

            <button class="btn btn-blue"
                @click="open = true" >
                Change ordering
            </button>

            @include('resource-type.attributes.options._order-modal')
        </header>
        

        {{ html()->form('PUT', route('resource-type.attributes.update', [$resourceType, $attribute]))->open() }}
            {{ html()->hidden("name", $attribute->name) }}
            {{ html()->hidden("type", $attribute->type) }}

            <section class="block mt-8 mb-8" data-target="resource-attribute.options">
                @if ($attribute->options)
                    @foreach ($attribute->options as $option) 
                        @if (is_array($option))
                            <h1 class="font-bold text-2xl">
                                {{ $option['_name'] }}
                            </h1>

                            @foreach ($option['_items'] as $item)
                                {{ html()->hidden("optionBlocks[{$option['_name']}]", $item)->class('form-input w-full mb-4') }}
                                <a class="block text-xl mb-1 cursor-pointer 200 py-1 underline"
                                    href="@route('resource-type.attribute.options.edit', [
                                        'resource_type' => $resourceType,
                                        'attribute' => $attribute,
                                        'option' => $option
                                    ])">
                                    {{ $option }}
                                </a>
                            @endforeach
                        @else
                            {{ html()->hidden('options[]', $option)->class('form-input w-full mb-4') }}
                            <a class="block text-xl mb-1 cursor-pointer 200 py-1 underline"
                                href="@route('resource-type.attribute.options.edit', [
                                    'resource_type' => $resourceType,
                                    'attribute' => $attribute,
                                    'option' => $option
                                ])">
                                {{ $option }}
                            </a>
                        @endif

                    @endforeach
                @else 
                    No Options for this dropdown yet
                @endif
                                
            </section>

            <footer x-data="{ addingOption: false }">
                <button class="btn btn-hollow mr-2" 
                    data-action="resource-attribute#addOption"
                    @click="addingOption = true">
                    <span x-show="!addingOption">
                        Add new option 
                    </span>
                    <span x-show="addingOption">
                        Add even more options!
                    </span>
                </button>
                
                <button class="btn btn-blue" 
                    x-show="addingOption">
                    Save Dropdown Options 
                </button>
            </footer>
        {{ html()->closeModelForm() }}
    </section>

    <section class="block my-20">
        <header class="text-2xl font-thin mb-2">
            Option Blocks 
        </header> 


        <main class="mb-8">
            @if ( collect($attribute->options)->count() == collect($attribute->options)->flatten()->count())
                <p>No Blocks... All options are on the same hierarchical level</p>
            @else 
                <header>
                    Blocks 
                </header>
            @endif
        </main>

        {{ html()->form('post', route('attribute.options.block.store', $attribute))->open() }}
            <input class="form-input" type="text" name="block" />

            <section class="block mt-8">
                <button class="btn btn-blue">
                    Add option block 
                </button>
            </section>
        {{ html()->form()->close() }}

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