@if ($errors->any())
    <div class="bg-red-200 p-2 my-2">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<label class="w-full px-2">
    <span class="text-gray-700">Resource Type</span>

    {{ html()->text('name')->class(['form-input', 'mt-1', 'block', 'w-full']) }}
</label>

<section class="px-2 my-4">

    <h1 class="font-semibold">
        Description of Resource Type 
    </h1>

    {{ html()->hidden('description')->attribute('id', 'description') }}
    <trix-editor input="description"></trix-editor>
</section>

