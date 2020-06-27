<div {{ $attributes }}>
    <header class="block mb-4">
        {{ $attribute->key }}
    </header>
    
    @foreach ($metas as $meta)
       <input wire:keyup.debounce.500ms="emitChange({{ $meta->id }})" value="{{ $meta->value }}" class="attribute form-input mt-1 block w-full font-medium" />
    @endforeach

</div>