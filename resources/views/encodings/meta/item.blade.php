<label class="w-1/2 px-2">
    <span class="text-gray-700 font-hairline">Tag Name</span>
    {{ html()->text('key')->class(['form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}
</label>

<label class="w-1/2 px-2">
    <span class="text-gray-700 font-hairline">Tag Value</span>
    {{ html()->text('value')->class(['form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}
</label>

@isset($meta) 
    <aside class="flex justify-end">
        <button class="btn btn-gray mr-4">
            Save Changes
        </button>
    </aside>        
@endisset
