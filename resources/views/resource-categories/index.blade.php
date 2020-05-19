@extends ('resource-type._layout')

@section ('content')

<ul class="block mt-12 text-xl"> 
    @foreach ($categories as $category)
        <li class="block mb-2">
            {{ $category->name }} <span class="text-sm">{{ $category->resources_count }}</span>
        </li>
    @endforeach
</ul>

<form action="@route('resource.categories.store', $resourceType)" method="post" class="mt-12">
    @csrf 

    <label class="block">
        Name 
        <input type="text" name="name" class="form-input block w-64" />
    </label> 

    <button class="btn btn-blue mt-4">
        Create new Category
    </button>
</form>

@endsection