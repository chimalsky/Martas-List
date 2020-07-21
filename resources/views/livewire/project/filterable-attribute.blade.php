<div>
    <h1 class="text-2xl font-semibold font-serif text-gray-700
        @if ($this->isActive)
            font-black text-black
        @endif
    ">
        <button type="button" wire:click="toggleDropdown"
            class="border-2 border-gray-700 py-1 px-3">
            @if ($expanded) 
                ^ 
            @else 
                V 
            @endif
        </button>
        {{ $attribute->key }} 
    </h1>

    <div class="grid grid-cols-5 pl-8 pt-2
        @unless($expanded) hidden @endunless
        ">
        @foreach ($options as $option)
            @unless(is_array($option))
                <label class="mb-2 col-span-1 text-2xl cursor-pointer hover:underline">
                    <input type="checkbox" wire:change="syncOptions('{{ $option }}')"
                        autocomplete="off" 
                        @if ($activeOptions->contains($option))
                            checked 
                        @endif
                         />
                    {{ $option }}
                </label>  
            @endunless 
        @endforeach
        <button class="mb-2 col-span-1 font-thin cursor-pointer hover:underline"
            wire:click="resetOptions()">
            Uncheck All
        </button>
    </div>
</div>
