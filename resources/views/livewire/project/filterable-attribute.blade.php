<div>
    <h1 class="text-xl font-semibold font-serif text-gray-700
        @if ($this->isActive)
            font-black text-black
        @endif
    ">
        <button type="button" wire:click="toggleDropdown"
            class="border-4 border-gray-500 p-2">
            @if ($expanded) 
                <x-heroicon-o-arrow-up class="w-4" />
            @else 
                <x-heroicon-o-arrow-down class="w-4" />
            @endif
        </button>
        {{ $attribute->key }} 
    </h1>

    <div class="pl-8 pt-2
        @unless($expanded) hidden @endunless
        ">
        <main class="grid grid-cols-5">
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
        </main>

        <footer class="flex justify-center pt-2">
            @if ($activeOptions->count() > 0)
                <button class="mb-2 col-span-1 p-2 font-thin cursor-pointer hover:underline border border-gray-600"
                    wire:click="resetOptions()">
                    Uncheck All
                </button>
            @endif
        </footer>
    </div>
    
</div>
