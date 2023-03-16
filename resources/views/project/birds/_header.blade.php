<h1 class="">
    <a href="@route('project.birds.show', $bird)"
        @routeIs('project.birds.show') class="font-bold" style="color: #bf9000;" @endrouteIs>
        {{ $bird->firstMetaByAttribute(500)->value ?? null }}
        <span class="italic">
            ({{ $bird->firstMetaByAttribute(501)->value ?? null }})
        </span>
    </a>

    | 

    @if ($bird->category)
        <a href="@route('project.bird.poems', $bird)" @routeIs('project.bird.poems') class="font-bold" style="color: #bf9000" @endrouteIs
            @routeIsnt('project.bird.poems') style="color: #806102" @endrouteIsnt>
            Affiliated Manuscripts
        </a>
    @else 
        <span class="text-gray-400">
            Affiliated Manuscripts
        </span>
    @endif

    | 

    <a href="@route('project.birds.data', $bird)" @routeIs('project.birds.data') class="font-bold" style="color: #bf9000;" @endrouteIs>
        Further Data
    </a>
</h1>

@routeIsnt('project.birds.data')
<header class="my-8 flex">
    <div class="mx-auto">
        <div style="color: #b8b6b9" class="inline-block text-lg align-middle italic mb-4">
            @if ($birdCategory)
                "{{ $birdCategory->name }}" appears in {{ $poems->count() }} 
                <a href="@route('project.bird.poems', $bird)" class="underline" style="color: #96a9a9">
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