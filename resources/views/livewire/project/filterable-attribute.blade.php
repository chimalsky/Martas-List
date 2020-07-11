<div>
    <h1 class="text-2xl">
        {{ $attribute->key }} 
        <button type="button" wire:click="toggleDropdown"
            class="border border-gray-500 p-1">
            @if ($expanded) 
                ^ 
            @else 
                V 
            @endif
        </button>
    </h1>

    @if ($expanded)
        <div class="grid grid-cols-5 pl-8 pt-2">
            @foreach ($options as $option)
                @unless(is_array($option))
                    <label class="mb-2 col-span-1 font-thin cursor-pointer hover:underline">
                        <input type="checkbox" wire:change="syncOptions('{{ $option }}')" />
                        {{ $option }}
                    </label>  
                @endunless
            @endforeach

            @if ($activeOptions)
                @foreach ($activeOptions as $ao)
                    {{ $ao }}
                @endforeach
            @endif
        </div>
    @endif
</div>
