<h1 class="text-lg md:text-xl md:text-2xl lg:text-4xl text-center mb-10">
    <a href="@route('project.birds.show', $bird)"
        @routeIs('project.birds.show') class="font-bold" style="color: #B45F06;" @endrouteIs>
        {{ $bird->firstMetaByAttribute(500)->value ?? null }}
        <span class="italic">
            ({{ $bird->firstMetaByAttribute(501)->value ?? null }})
        </span>
    </a>

    | 

    @if ($bird->category)
        <a href="@route('project.bird.poems', $bird)" @routeIs('project.bird.poems') class="font-bold" style="color: #B45F06" @endrouteIs
            @routeIsnt('project.bird.poems') style="color: #806102" @endrouteIsnt>
            Affiliated Manuscripts
        </a>
    @else 
        <span class="text-gray-400">
            Affiliated Manuscripts
        </span>
    @endif

    | 

    <a href="@route('project.birds.data', $bird)" @routeIs('project.birds.data') class="font-bold" style="color: #B45F06;" @endrouteIs>
        Further Data
    </a>
</h1>

@routeIsnt('project.birds.data')
<header class="my-12 flex">
    <div class="mx-auto">
        <div class="inline-block text-3xl align-middle italic mb-4">
            @if ($birdCategory)
                "{{ $birdCategory->name }}" appears in {{ $poems->count() }} 
                <a href="@route('project.bird.poems', $bird)" class="underline text-blue-700">
                    @if ($poems->count() === 1)
                        Poem
                    @else 
                        Poems
                    @endif
                </a>
            @else 
                "{{ $bird->name }}" is not named in Dickinson's writings.
            @endif 
        </div>

        <x-project.bird.xc :bird="$bird" class="col-span-1" width="340" height="220" />
    </div>
</header>
@endrouteIsnt