<div>
    <ul wire:sortable="updateOptionsOrder">
        @foreach ($options as $option)
            <li wire:sortable.item="{{ $option->id }}" wire:key="option-{{ $option->id }}">
                <h4 wire:sortable.handle>{{ $option->value }}</h4>
            </li>
        @endforeach
    </ul>
</div>
