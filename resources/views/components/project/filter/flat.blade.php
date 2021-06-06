@foreach ($filterable->nonNullOptions as $option)
    @php
        if (is_array($option)) {
            $option = $option['_name'];
        }
    @endphp 

    <x-project.filter.input :filterable="$filterable" :option="$option" 
        data-action="change->form#changed" />
@endforeach