{{ html()->select("newAttribute[id-" . $attribute->id . "]", $attribute->optionsDropdown)
    ->placeholder('Add Info!')
    ->class(['attribute', 'form-input', 'form-dropdown', 'mt-1', 'block', 'w-full', 'font-medium']) }}