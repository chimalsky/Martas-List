@extends ('layouts.project')

@section ('header')
    @include('project._nav', ['title' => 'About the Project'])
@endsection

@section ('content')

<main class="max-w-2xl mx-auto text-gray-700 text-lg">
    <header class="mb-8 text-2xl">
        Dickinson’s Birds: A Public Listening Project
    </header> 

    <section>
        <p class="block mb-4">
            Of the more than 500 species of birds known to nest in the fertile Connecticut River Valley or pass through it on their long migrations, Emily Dickinson named a relatively small number of them, possibly just those she heard from her window or observed in her garden: robins, bobolinks, sparrows, jays, crows, eagles, cardinals, orioles, larks, phoebes, black- and blue-birds, lapwings, hummingbirds, owls, eider ducks, swans, whippoorwills, partridges, cuckoos, doves, linnets, and wrens. Yet birdsong is arguably the most constant evanescent sound she recorded through writing in an age before the technologies of recording had been invented.  
        </p>

        <p class="block">
            “Dickinson’s Birds: A Public Listening Project” reconstructs—as far as possible—her 19th-century bird-sound-scape to propose a new way of understanding the complex conjunctions and disjunctions between the human and non-human worlds in her poetry and to invite further inquiry into the importance of sound in her modes of knowing/writing as well as her fellow inhabitants’ orientation to the sonic epicenter of Dickinson’s world: birdsong.
        </p>
    </section>

    <section class="mt-12">
        <p class="font-semibold mb-2">
            To this end, Dickinson’s Birds” has four principal objectives:
        </p>

        <ul class="list-inside list-disc pl-4">
            <li class="mb-3">
                To recreate as far as possible one sonic element of Dickinson’s layered and intricate soundscape: the sounds of the birds of Amherst, Massachusetts and the Connecticut River Valley as she may have heard them from her window and her garden more than a century and a half ago. 
            </li>
            <li class="mb-3">
                To generate, via digital timelines and deep maps, dynamic images of Dickinson’s engagement with birds in her poetry across the years 1853–1886 in order to enlarge our understanding of the relationship between Dickinson’s bird-poems and her evolving sense of emplacement and to assess the possible effects of widespread ecological change associated with the Industrial Revolution on her experience of place and nature.
            </li>
            <li class="mb-3">
                To expand and fundamentally re-imagine the space of the archive not only as a repository of static and isolated information essential for the preservation of human history, but as an open, living environment that shelters traces of both the human and the non-human even in their imagining of their own endings.
            </li>
            <li class="mb-3">
                To develop a collaborative public listening project that fosters increased awareness in users of the fates of the descendants of Dickinson’s birds in the 21st century and encourages reflections from diverse perspectives—from readers of Dickinson, to birders and environmentalists, geographers and sound-scape ecologists, musicians and artists—on poetry, birds, and ecology in the era of the Sixth Mass Extinction. 
            </li>
        </ul>
    </section>
</main>

@endsection