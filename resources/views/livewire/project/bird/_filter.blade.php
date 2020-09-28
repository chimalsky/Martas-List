<div id="js-poems-filter" class="relative w-full bg-white shadow-lg">
    <header class="block">
        <h1 style="background: #B45F06" class="font-serif text-2xl text-white font-garamond font-thin p-3 italic shadow-xl flex justify-between">
            <span class="text-center w-full pl-6">
                Sort By--
            </span>

            <button class="float-right" @click="open = false">
                <x-heroicon-o-x class="w-8" />
            </button>
        </h1>
    </header>

    <main class="w-full flex flex-wrap">
        <div class="p-4 w-5/12">
            <x-project.filter.dickinsons-birds :dickinsonsBirds="$dickinsonsBirds" :activeBirdCategories="$activeBirdCategories" />
        </div>
        <div class="p-4 w-5/12">
            <h1>
                Seasons
            </h1>

            <main class="grid grid-cols-3">
                @php 
                    $seasons = [
                        'Permanent Resident',
                        'Winter',
                        'Spring',
                        'Summer',
                        'Fall'
                    ];
                @endphp 
                <section class="col-span-1">
                    @foreach ($seasons as $season)
                        <label class="mb-2 block container relative text-base cursor-pointer hover:underline">
                            <input type="checkbox"
                                class=""
                                autocomplete="off" />
                            <span class="checkmark border-2 border-gray-500"></span>

                            <span class="pl-6">
                                {{ $season }}
                            </span>
                        </label> 
                    @endforeach
                </section>

                @php
                    $months1 = [
                        'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June'
                    ];

                    $months2 = [
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December'
                    ];
                @endphp
                <section class="col-span-1">
                    @foreach ($months1 as $month)
                        <label class="mb-2 block container relative text-base cursor-pointer hover:underline">
                            <input type="checkbox"
                                class=""
                                autocomplete="off" />
                            <span class="checkmark border-2 border-gray-500"></span>

                            <span class="pl-6">
                                {{ $month }}
                            </span>
                        </label> 
                    @endforeach
                </section>
                <section class="col-span-1">
                    @foreach ($months2 as $month)
                        <label class="mb-2 block container relative text-base cursor-pointer hover:underline">
                            <input type="checkbox"
                                class=""
                                autocomplete="off" />
                            <span class="checkmark border-2 border-gray-500"></span>

                            <span class="pl-6">
                                {{ $month }}
                            </span>
                        </label> 
                    @endforeach
                </section>
            </main>
        </div>
        <div class="p-4 w-2/12">
        </div>
    </main>

</div>