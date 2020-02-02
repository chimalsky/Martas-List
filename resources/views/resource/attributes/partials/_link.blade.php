{{ html()->text("newAttribute[id-" . $attribute->id . "]")
    ->placeholder('Add a link!')
    ->attribute('data-target', 'link')
    ->class(['attribute', 'form-input', 'mt-4', 'block', 'w-full', 'font-medium']) }}