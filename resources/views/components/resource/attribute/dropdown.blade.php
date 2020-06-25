<div>
    {{ html()->select("attribute[id-]", $attribute->optionsDropdown, null)
        ->class(['attribute', 'form-dropdown', 'mt-1', 'block', 'w-full', 'font-medium']) }}
</div>