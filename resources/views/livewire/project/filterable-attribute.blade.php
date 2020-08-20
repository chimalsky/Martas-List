<div>
    <h1 class="text-xl font-semibold font-serif text-gray-700
        @if ($this->isActive)
            font-black text-black
        @endif
    ">
        <button type="button" wire:click="toggleDropdown"
            class="border-2 border-gray-700 py-1 px-3">
            @if ($expanded) 
                <x-heroicon-o-arrow-up class="w-4" />
            @else 
                <x-heroicon-o-arrow-down class="w-4" />
            @endif
        </button>
        {{ $attribute->key }} 
    </h1>

    <div class="grid grid-cols-5 pl-8 pt-2
        @unless($expanded) hidden @endunless
        ">
        @foreach ($options as $option)
            @unless(is_array($option))
                <label class="mb-2 container relative text-base col-span-1 cursor-pointer hover:underline">
                    <input type="checkbox" wire:change="syncOptions('{{ $option }}')"
                        class=""
                        autocomplete="off" 
                        @if ($activeOptions->contains($option))
                            checked 
                        @endif
                            />
                    <span class="checkmark border-2 border-gray-500"></span>

                    <span class="pl-6">
                        {{ $option }}
                    </span>
                </label> 
            @endunless 
        @endforeach
        <button class="mb-2 col-span-1 font-thin cursor-pointer hover:underline"
            wire:click="resetOptions()">
            Uncheck All
        </button>
    </div>
</div>
