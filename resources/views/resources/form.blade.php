@if ($errors->any())
    <div class="bg-red-200 p-2 my-2">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{ html()->hidden('resource_type_id', $resource->definition->id ?? $resourceType->id) }}


<label class="w-full px-2">
    <span class="text-gray-700">Name</span>

    {{ html()->text('name')->class(['form-input', 'mt-1', 'block', 'w-full']) }}
</label>
