@extends ('layouts.resources.edit')

@section ('content')

<form action="{{ route('resource.connections.store', $resource) }}" method="post"
    data-controller="resource-types" 
    data-resource-types-search-url="{{ route('resources.index') }}" 
    class="mt-8 shadow p-4 mb-4">
    @csrf

    <h1 class="m-2 font-semibold">
        Forge connections between {{ $resource->name }} and {{ $connectingResource->name }}
    </h1>

    @foreach ($connectingResource->resources->sortBy('name') as $connecting) 
        <article class="block mb-4">
            <label class="cursor-pointer hover:bg-gray-200 p-2">
                <input type="checkbox" name="resources[]" value="{{ $connecting->id }}" /> 
                {{ $connecting->name }} 
            </label>
        </article>
    @endforeach


    <button class="btn btn-hollow">
        Forge this resource connection
    </button>
</form>

@endsection