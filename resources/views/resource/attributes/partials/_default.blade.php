{{ html()->text("newAttribute[id-" . $attribute->id . "]")
    ->placeholder('Add Info!')
    ->class(['attribute', 'form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}