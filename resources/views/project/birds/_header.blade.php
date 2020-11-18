<h1 class="text-2xl md:text-3xl lg:text-4xl font-hairline text-center">
    <a href="@route('project.birds.show', $bird)" style="color:#B45F06">
        {{ $bird->firstMetaByAttribute(500)->value ?? null }}
        <span class="italic">
            ({{ $bird->firstMetaByAttribute(501)->value ?? null }})
        </span>
    </a>

    | 

    @if ($bird->category)
        <a href="@route('project.bird.poems', $bird)" class="">
            Affiliated Manuscripts
        </a>
    @else 
        <span class="text-gray-400">
            Affiliated Manuscripts
        </span>
    @endif

    | 

    <a href="@route('project.birds.data', $bird)">
        Further Data
    </a>
</h1>

@routeIsnt('project.birds.data')
<header class="my-12 flex">
    <div class="mx-auto">
        <div class="grid grid-cols-2 gap-4">
            <x-project.bird.xc :bird="$bird" class="col-span-1" />
            
            <div class="col-span-1 text-center text-lg">

            @if ($birdCategory)
                "{{ $birdCategory->name }}" appears in {{ $poems->count() }} 
                <a href="#poems">
                    @if ($poems->count() === 1)
                        Poem
                    @else 
                        Poems
                    @endif
                </a>
            @else
                "{{ $bird->name }}" is never mentioned by Dickinson
            @endif
        </div>
    </div>
</header>
@endrouteIsnt