<h1 class="text-2xl md:text-3xl lg:text-4xl text-center">
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
        @if ($birdCategory)
            <div class="">
                <div class="inline-block align-middle">
                    <img src="/img/binoculars.png" class="w-24 h-auto mx-auto" />
                </div>
                <div class="inline-block text-xl align-middle italic">
                    "{{ $birdCategory->name }}" appears in {{ $poems->count() }} 
                    <a href="@route('project.bird.poems', $bird)" class="underline text-blue-700">
                        @if ($poems->count() === 1)
                            Poem
                        @else 
                            Poems
                        @endif
                    </a>
                </div>
            </div>

            <x-project.bird.xc :bird="$bird" class="col-span-1" />

        @else 
            <div class="flex justify-center">
                <x-project.bird.xc :bird="$bird" />
            </div>

            <p class="text-base mt-4 italic">
                "{{ $bird->name }}" is not named in Dickinson's writings.
            </p>
        @endif
    </div>
</header>
@endrouteIsnt