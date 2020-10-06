

<label class="w-full">
    <span class="">Archive Name</span>

    {{ html()->text('name')->class(['form-input', 'mt-1', 'mb-8', 'block', 'w-full']) }}
</label>

<section class="bg-gray-200 text-gray-700">
    <h1 class="font-semibold px-2">
        Description of this Archive 
    </h1>

    <input name='description' id='description' value="{!! $resourceType->description !!}" />
    <trix-editor input="description"></trix-editor>
</section>
