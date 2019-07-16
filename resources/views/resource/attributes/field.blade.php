
<label class="w-4/5 px-2">
    <input type="hidden" name="key" value="{{ $attribute->name ?? $attribute->key }}" />
    
    {{ html()->text('value')->class(['form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}
</label>
