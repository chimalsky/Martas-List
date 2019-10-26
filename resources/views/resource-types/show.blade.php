@extends ('layouts.web')

@section ('content')

<header class="flex align-left mb-8">
    <a href="{{ route('resource-types.index') }}">
        Resources
    </a>

    <span class="mx-4">
        >
    </span>

    <p class="mx-2 font-bold underline">
        {{ $resourceType->name }} 
    </p>
</header>


<section class="mb-8 max-w-4xl">
    <header class="flex justify-between">
        <p class="text-gray-700 text-xl">
            {{ $resourceType->name }} 

            <span>
                <a href="{{ route('resource-types.edit', $resourceType) }}"
                    class="text-xs btn btn-hollow ml-2">
                    Edit 
                </a>
            </span>
        </p>

        <section class="">
            <p class="inline-block mr-2">
                <strong>
                    {{ $resourceType->resources()->count() }}
                </strong>
                Resources
            </p>
            <a href="{{ route('resource-type.resources.create', $resourceType) }}"
                class="inline-block btn btn-blue">
                Add New 
            </a>
        </section>
    </header>

    <div class="my-4 block">
       {!! $resourceType->description !!}
    </div>
</section>

@if($resourceType->resources->count())
    <section class="w-full max-w-4xl">
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th>
                    </th>
                    <th>
                    </th>
                    <th>
                    </th>
                </tr>
            </thead>
            <tbody class="">
                @foreach($resourceType->resources as $resource)
                    <tr class="w-full border-b border-gray-400 hover:bg-gray-200 hover:cursor-pointer">
                        <td class="py-2 pl-2">
                            <a href="{{ route('resources.edit', $resource) }}" class="text-blue-600">
                                {{ $resource->name }}
                            </a>
                        </td>
                        
                        <td>
                            {{ $resource->excerpt }}
                        </td>
                        
                        <td class="text-right pr-2">
                            <time-ago datetime="{{ $resource->updated_at }}">
                                {{ $resource->updated_at }}
                            </time-ago>
                        </td>
                    </tr>
                @endforeach 
            </tbody>
        </table>
    </section>
@else 
    <h1 class="text-xl">
        No {{ $resourceType->name }} yet...  
    </h1>
@endif

@endsection