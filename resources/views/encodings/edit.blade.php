@extends('layouts.web')

@section('content')

<header class="my-8 flex justify-between">
    <a class="btn btn-gray align-top" href="{{ route('encodings.index') }}">
        Return to my list of Encodings 
    </a>

    {{ html()->form('DELETE', route('encodings.destroy', $encoding))->open() }}
        <button class="btn btn-red align-top">
            Delete
        </button>
    {{ html()->form()->close() }}
</header>


<form action="{{ route('encoding.metas.store', $encoding) }}" method="post"
    class="mt-8 bg-gray-300 p-4 mb-4">
    @csrf

    <h1 class="m-2 font-semibold">
        Add new tag 
    </h1>

    @include('encodings.meta.form')

    <button class="btn btn-blue">
        Add this tag to encoding {{ $encoding->encoder_assigned_id }}
    </button>
</form>


<form action="{{ route('encoding.resources.store', $encoding) }}" method="post"
    data-controller="resource-types" 
    data-resource-types-search-url="{{ route('resources.index') }}" 
    class="mt-8 bg-red-200 p-4 mb-4">
    @csrf

    <h1 class="m-2 font-semibold">
        Attach resources to {{ $encoding->encdoer_assigned_id }} 
    </h1>

    <select name="resource_type_id" data-action="resource-types#select">
        <option>
            Pick a resource type 
        </option> 

        @foreach (App\ResourceType::all() as $type)
            <option value="{{ $type->id }}">
                {{ $type->name }}
            </option>
        @endforeach
    </select>

    <div data-target="resource-types.results" class="my-8 flex flex-wrap">

    </div>

    <button class="btn btn-hollow">
        Attach this resource to encoding {{ $encoding->encoder_assigned_id }}
    </button>
</form>


<section class="flex flex-wrap mb-8 p-4 border border-1 border-gray-600">
    {{ html()->modelForm($encoding, 'PUT', route('encodings.update', $encoding))->open() }}
        @include('encodings.form')

        <footer class="py-4 justify-end">
            <button class="btn btn-blue">
                Save Changes 
            </button>
        </footer>
    {{ html()->closeModelForm() }}
</section>

<section class="flex flex-wrap my-4">
    <h1 class="m-2 text-2xl w-full">
        @if ($encoding->meta->count())
            Existing Tags 
        @else 
            Add Some Tags to that Encoding!
        @endif
    </h1>

    @foreach ($encoding->meta->reverse() as $meta)
        <article class="w-full md:w-1/2 lg:w-1/3 border border-1 border-gray-400 mb-4 p-2">
            {{ html()->modelForm($meta, 'PUT', route('encoding.metas.update', [
                'encoding' => $encoding, 
                'meta' => $meta
            ] ))->open() }}
                
                @include('encodings.meta.item', ['meta' => $meta])

            {{ html()->closeModelForm() }}

            {{ html()->modelForm($meta, 'DELETE', route('encoding.metas.destroy', [
                'encoding' => $encoding, 
                'meta' => $meta
            ] ))->open() }}
                <div class="flex justify-end mr-4 mt-4">
                    <button class="btn btn-red">
                        Delete
                    </button>
                </div>
            {{ html()->closeModelForm() }}
        </article>
    @endforeach
</section>


@foreach (App\ResourceType::all() as $type)
    <section class="flex flex-wrap my-4">
        <h1 class="m-2 text-2xl w-full">
            @if ($encoding->resources->count())
                Attached {{ $type->name }}
            @else 
                Attach some {{ $type->name }} to that Encoding!
            @endif
        </h1>

        @foreach ($encoding->resources()->type($type->id)->get()->reverse() as $resource)
            <article class="w-full md:w-1/2 lg:w-1/3 border border-1 border-gray-400 mb-4 p-4">
                <a href="{{ route('resources.edit', $resource) }}">
                    {{ $resource->name }}
                </a>

                {{ html()->modelForm($resource, 'DELETE', route('encoding.resources.destroy', [
                    'encoding' => $encoding,
                    'resource' => $resource, 
                ] ))->open() }}
                    <div class="flex justify-end mr-4 mt-4">
                        <button class="btn btn-red">
                            Detach
                        </button>
                    </div>
                {{ html()->closeModelForm() }}
            </article>
        @endforeach
    </section>
@endforeach


@endsection