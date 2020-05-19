@extends ('layouts.web')

@section ('header')
<section class="web container mx-auto">
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
    </header>

    <header class="flex justify-between">
        <a href="{{ route('resource-types.show', $resourceType) }}" class="text-gray-500 text-xl">
            {{ $resourceType->name }} 
        </p>
    </header>

    <section class="border-b border-indigo-300 mt-2 mb-4">
        <nav class="inline-block">
            <a href="{{ route('resource-types.show', $resourceType) }}"
                class="p-2 mr-2 border-t-4 border-transparent
                @unless (request()->is('resource-types/*/edit')))
                    {{ (request()->is('resource-types/*')) ? 'border-indigo-400 font-semibold' : '' }}
                @endunless
                ">
                Resources
            </a>

            <a href="{{ route('resource-type.attributes.index', $resourceType) }}"
                class="p-2 mr-2 border-t-4
                {{ (request()->is('resource-type/*/attributes')) ? 'border-indigo-400 font-semibold' : 'border-transparent' }}
                ">
                Attributes
            </a>

            <a href="{{ route('resource.categories.index', $resourceType) }}"
                class="p-2 mr-2 border-t-4 border-transparent
                {{ (request()->is('resource-type/*/categories')) ? 'border-indigo-400 font-semibold' : '' }}
                ">
                Categories
            </a>

            <a href="{{ route('resource-types.edit', $resourceType) }}"
                class="p-2 mr-2 border-t-4
                {{ (request()->is('resource-types/*/edit')) ? 'border-indigo-400 font-semibold' : 'border-transparent' }}
                ">
                Settings
            </a>

            <a href="{{ route('resource-type.spreadsheetImport.show', $resourceType) }}"
                class="p-2 mr-2 border-t-4
                {{ (request()->is('resource-type/*/spreadsheet-import')) ? 'border-indigo-400 font-semibold' : 'border-transparent' }}
                ">
                Spreadsheet Import
            </a>

            <a href="{{ route('resource-type.activities.index', $resourceType) }}"
                class="p-2 mr-2 border-t-4
                {{ (request()->is('resource-type/*/activities')) ? 'border-indigo-400 font-semibold' : 'border-transparent' }}
                ">
                Change Log
            </a>
        </nav>

        <section class="inline-block px-2 py-1">
            <p class="inline-block mr-2">
                <strong>
                    {{ $resourceType->resources()->count() }}
                </strong>
                Resources
            </p>
            <a href="{{ route('resource-type.resources.create', $resourceType) }}"
                class="inline-block btn btn-blue">
                Add New {{ $resourceType->nameSingular }}
            </a>
        </section>
    </section>
</section>

@endsection