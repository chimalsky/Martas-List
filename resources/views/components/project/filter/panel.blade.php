<div>
    @if ($filterable->id == 131)
        <x-project.filter.year :filterable="$filterable" />
    @elseif ($filterable->hasOptionBlocks()) 
        <x-project.filter.nested :filterable="$filterable" />
    @else
        <x-project.filter.flat :filterable="$filterable" />
    @endif
</div>