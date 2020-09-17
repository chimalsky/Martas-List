<div x-data="{expanded: false}">
    <h1 class="text-xl font-semibold font-serif text-gray-700
        @if ($this->isActive)
            font-black text-black
        @endif
    ">
        <button type="button" @click="expanded = !expanded"
            class="border-2 border-gray-500 p-1">
            <x-heroicon-o-chevron-up class="w-3" x-show="expanded" />
            <x-heroicon-o-chevron-down class="w-3" x-show="!expanded" />
        </button>
        {{ $attribute->key }} 
    </h1>

    <div class="pl-8 pt-2" x-show="expanded"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-50 -translate-y-full -translate-x-full"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-50 -translate-y-full -translate-x-full">
        <main class="grid grid-cols-5">
            @foreach ($options as $option)
                @unless(is_array($option))
                    @unless(is_null($option))
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
