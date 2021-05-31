@foreach($poemYears as $year => $poems)
    <header style="background-color: #F7F5E7" class="text-xl mb-2 ml-6 sticky top-0 pb-2 px-2 shadow-md">
        {{ $year }}
    </header>

    <x-project.poem.list :poems="$poems"/>
@endforeach