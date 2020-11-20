<header class="text-gray-800 mb-4">
    {{ $header }}
</header>
@foreach ($dickinsonsBirds as $birdC)
    <div class="border-l-4 border-red-400 pl-4 mb-2">
        <header class="font-bold text-gray-800" x-data="{expanded: false}">
            <span @click="expanded = !expanded">
                {{ $birdC->name }}
            </span>
            <span x-show="expanded">
                <button wire:click="$emitTo('project.poem.filter', 'activeBirdRemoved', {{ $birdC->id }})">
                    <x-heroicon-o-x-circle class="w-4" />
                </button>
            </span>
        </header>

        @foreach( $birdC->resources as $resource )
            {{ $resource->name }} @unless($loop->last),@endunless
        @endforeach
    </div>

@endforeach