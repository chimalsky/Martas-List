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
            <x-project.filter.presence :activeSeasons="$activeSeasons" :activeMonths="$activeMonths" :activeChrono="$activeChrono" />
        </div>
        <div class="p-4 w-2/12">
        </div>
    </main>

</div>