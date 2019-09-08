@if ($attribute->type == 'rich-text')
    {{ html()->hidden('value')->attribute('id', $attribute->key) }}
    <trix-editor input="{{ $attribute->key }}"></trix-editor>
@elseif ($attribute->type == 'encoding')
    <h1 class="font-semibold">
        Mock Encoding -- textbox is resizable as needed from bottom-right corner
    </h1>

    {{ html()->textarea('value')
        ->class(['w-full', 'block', 'border', 'border-2', 'border-black'])
        ->attribute('id', $attribute->key)
    }}
@elseif ($attribute->type == 'temporality')
    <h1 class="text-semibold">
        {{ $attribute-> }}
    </h1>
    <input type="hidden" name="key" value="{{ $attribute->key }}" />

    <input type="date" class="date-element" name="value" value="{{ $attribute->value }}" />
@else
    <label class="w-4/5 px-2">
        <input type="hidden" name="key" value="{{ $attribute->key }}" />
        
        {{ html()->text('value')->class(['form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}
    </label>
@endif
