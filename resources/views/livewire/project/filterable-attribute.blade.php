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

    <div class="grid grid-cols-5 pl-8 pt-2
        @unless($expanded) hidden @endunless
        ">
        @foreach ($options as $option)
            @unless(is_array($option))
                <label class="mb-2 col-span-1 font-thin cursor-pointer hover:underline">
                    <input type="checkbox" wire:change="syncOptions('{{ $option }}')" />
                    {{ $option }}
                </label>  
            @endunless
        @endforeach
    </div>
</div>
