@extends ('resource-type._layout')

@section ('content')

<section class="flex flex-wrap mb-8">
    {{ html()->modelForm($resourceType, 'PUT', route('resource-types.update', $resourceType))->open() }}
        @include('resource-types.form')

        <footer class="py-4">
            <button class="btn btn-hollow">
                Save changes to this Archive 
            </button>
        </footer>
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