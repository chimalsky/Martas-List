


<div>
    @foreach ($months as $key => $value)
        <label class="mb-2 block container relative text-base cursor-pointer hover:underline">
            <input wire:model="activeMonth"
                value="{{ $value }}"
                type="radio"
                autocomplete="off" 
                />
            <span class="pl-6 @if ($activeMonth == $value) font-black @endif">
                {{ Str::title($key) }}
            </span>
        </label> 
    @endforeach


    <div class="mt-24"></div>

    <main class="text-right">
        <div class="block flex justify-end">
            <div>
                @foreach ($groupedBirds[0] as $bird)
                    <span>
                        + {{ $bird->name }}
                    </span>

                    @if ($loop->index == 5)
                        <br/>
                    @endif

                    @if ($loop->index == 9)
                        <br/>
                    @endif

                    @if ($loop->index == 13)
                        <br/>
                    @endif

                    @if ($loop->index == 17)
                        <br/>
                    @endif

                    @if ($loop->index == 19)
                        <br/>
                    @endif

                    @if ($loop->index == 21)
                        <br/>
                    @endif

                    @if ($loop->index >= 23)
                        <br/>
                    @endif
                @endforeach
            </div>
        </div>
        <div class="block flex justify-end">
            <div>
                @foreach ($groupedBirds[1] as $bird)
                    <span>
                        + {{ $bird->name }}
                    </span>

                    @if ($loop->index === 0)
                        <br/>
                    @endif

                    @if ($loop->index == 2)
                        <br/>
                    @endif

                    @if ($loop->index == 4)
                        <br/>
                    @endif

                    @if ($loop->index == 6)
                        <br/>
                    @endif

                    @if ($loop->index == 9)
                        <br/>
                    @endif

                    @if ($loop->index == 13)
                        <br/>
                    @endif

                    @if ($loop->index == 18)
                        <br/>
                    @endif
                @endforeach
            </div>
        </div>

        <div class='w-full h-12'></div>

        <div class="block flex justify-end">
            <div>
                @foreach ($groupedBirds[0] as $bird)
                    <span>
                        + {{ $bird->name }}
                    </span>

                    @if ($loop->index == 5)
                        <br/>
                    @endif

                    @if ($loop->index == 9)
                        <br/>
                    @endif

                    @if ($loop->index == 13)
                        <br/>
                    @endif

                    @if ($loop->index == 17)
                        <br/>
                    @endif

                    @if ($loop->index == 19)
                        <br/>
                    @endif

                    @if ($loop->index == 21)
                        <br/>
                    @endif

                    @if ($loop->index >= 23)
                        <br/>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="block flex justify-end">
            <div>
                @foreach ($groupedBirds[2] as $bird)
                    <span>
                        + {{ $bird->name }}
                    </span>

                    @if ($loop->index === 0)
                        <br/>
                    @endif

                    @if ($loop->index == 2)
                        <br/>
                    @endif

                    @if ($loop->index == 4)
                        <br/>
                    @endif

                    @if ($loop->index == 6)
                        <br/>
                    @endif

                    @if ($loop->index == 9)
                        <br/>
                    @endif

                    @if ($loop->index == 13)
                        <br/>
                    @endif

                    @if ($loop->index == 18)
                        <br/>
                    @endif
                @endforeach
            </div>
        </div>

        
    </main>
</div>
