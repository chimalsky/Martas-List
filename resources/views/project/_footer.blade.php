@routeIs('project.index')
<div>
    <i>Dickinson’s Birds</i> &#169; {{ carbon()->format('Y') }}, 
    currently under Phase 1 development, 
    is licensed under a Creative Commons Attribution 4.0 International License. 
    Support for this project has been provided by the Office of Research Services and the Center for 
    Textual Studies and Digital Humanities, Loyola University.
</div>
@endrouteIs

@routeIsnt('project.index')
<div class="text-lg">
    <p class="">
        Dickinson’s Birds: A Public Listening Project &#169; {{ carbon()->format('Y') }}
    </p>
    <p class="text-gray-700 mb-8">
        Site under phase 1 development.
    </p>
    <p>
        Curated by Marta Werner, Caroline McCraw, Abraham Kim, and Danielle Richards
    </p>
</div>

<div class="block mt-8">
    <p class="block">
        Funding and Support provided by Loyola University, Office of Research
    </p>

    <p class="block text-gray-600">
        Licensed under Creative Commons Attribution 4.0 International License, 2020
    </p>
</div>

<div class="block mt-12 text-right">
    @auth
        <a href="{{ route('resource-types.index') }}" class="no-underline hover:underline text-sm font-normal text-teal-800">Go to Archiver</a>
    @else
        <a href="{{ route('login') }}" class="no-underline hover:underline text-sm font-normal text-teal-800 pr-6">{{ __('Login') }}</a>
    @endauth
</div>
@endrouteIsnt('project.index')
