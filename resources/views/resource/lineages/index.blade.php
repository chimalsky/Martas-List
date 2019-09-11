@extends ('layouts.resources.edit')

@section ('content')

    <h1 class="text-2xl">
        Associate to a Parent
    </h1>
   
    {{ html()->form('POST', route('resource.lineages.store', $resource))->open() }}
        <section class="flex flex-wrap mb-8">
            @foreach($resource->definition->resources as $potentialParent)
                <label class="p-4">
                    <input name="parent" value="{{ $potentialParent->id }}" type="radio" class="form-radio" 
                        @if ($potentialParent->id == $resource->parent_id) checked @endif />
                        {{ $potentialParent->name }}

                    <aside class="italic">
                        {!! $potentialParent->excerpt !!}
                    </aside>
                </label>
            @endforeach
        </section>

        <button class="btn btn-blue">
            Attach {{ $resource->name }} to this parent
        </button>
    {{ html()->form()->close() }}

    <h1 class="text-2xl mt-32">
        Add Children
    </h1>
   
    {{ html()->form('POST', route('resource.lineages.store', ['resource' => $resource, 'children' => true]))->open() }}
        <section class="flex flex-wrap mb-8">
            @foreach($resource->definition->resources as $potentialChildren)
                <label class="p-4">
                    <input name="child[]" value="{{ $potentialChildren->id }}" type="checkbox" class="form-checkbox" 
                        @if ($resource->children->pluck('id')->contains($potentialChildren->id)) checked @endif />
                        {{ $potentialChildren->name }}

                    <aside class="italic">
                        {!! $potentialChildren->excerpt !!}
                    </aside>
                </label>
            @endforeach
        </section>

        <button class="btn btn-blue">
            Attach children to {{ $resource->name }}
        </button>
    {{ html()->form()->close() }}
@endsection