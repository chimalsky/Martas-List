<div>
<main class="flex flex-wrap w-full pt-12">
    <div wire:loading class="w-full flex justify-center">
        <div wire:loading class="animate-ping h-12 w-12 text-gray-700 hover:text-gray-500 focus:outline-none 
            focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 
            transition ease-in-out duration-150">
            <img src="{{ asset('img/bird-icon-round.png') }}" />
        </div>
    </div>
    
    @foreach ($birds as $bird)
    <article class="pb-32 px-4 w-full lg:w-1/2 xl:w-1/3">
        @include('project.birds._single', ['bird' => $bird])
    </article> 
    @endforeach

    @if ($readyToLoad)
        @if ($birds->count() > $perPage)
        <div class="w-full">
        </div>  
        @endif
    @endif 
</main>


</div>
