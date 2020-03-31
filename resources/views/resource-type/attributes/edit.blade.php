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
            <span class="text-gray-700 mb-2 w-full">Name</span>
            
            {{ html()->text("name", $attribute->name)->class(['form-input', 'mt-1', 'w-full', 'mb-2']) }}
        </label>

        <label class="block my-2">
            <span class="block">
                Type: 
            </span>

            {{ html()->select("type", $resourceType->availableTypes, $attribute->type)
                ->class(['attribute', 'form-dropdown', 'mt-1', 'block', 'w-full', 'font-medium']) }}
        </label>
        

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

                        
            <div x-show="open">
                <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                class="hidden fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-500 opacity-75">
                    </div>
                </div>

                <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    {{ html()->form('POST', route('resource-type.attribute.options.sort', [$resourceType, $attribute]))->open() }}
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                
                            </div>
                            
                            <section class="sortable mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex flex-wrap ">
                                @if ($attribute->options)
                                    @foreach ($attribute->options as $index => $option) 
                                        <article class="block my-2 mx-2 cursor-pointer hover:bg-gray-200 py-1">
                                            <span class="text-gray-500">
                                                {{ $index + 1 }}
                                            </span>
                                            {{ html()->hidden('options[]', $option) }}
                                            {{ $option }}
                                        </article>
                                    @endforeach
                                @else 
                                    There are no options to order yet!!
                                @endif
                            </section>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                            <button class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-green-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-green-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Change order
                            </button>
                        </span>
                        <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                            <button @click.prevent="open = false" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                Nevermind
                            </button>
                        </span>
                    </div>
                    {{ html()->form()->close() }}
                </div>
            </div>
        </header>
        

        {{ html()->form('PUT', route('resource-type.attributes.update', [$resourceType, $attribute]))->open() }}
            {{ html()->hidden("name", $attribute->name) }}
            {{ html()->hidden("type", $attribute->type) }}

            <section class="block mt-8 mb-8" data-target="resource-attribute.options">

                @if ($attribute->options)
                    @foreach ($attribute->options as $option) 
                        {{ html()->hidden('options[]', $option)->class('form-input w-full mb-4') }}
                        <a class="block text-xl mb-1 cursor-pointer hover:bg-gray-200 py-1"
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