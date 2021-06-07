@routeIs('project.index')
<div class="text-center">
    <i>Dickinson’s Birds</i> &#169; {{ carbon()->format('Y') }}
    <br>
    <strong>Site under phase 1 development.</strong>

    <br><br>

    Support for this project has been provided by the Office of Research Services 
    and the Center for Textual Studies and Digital Humanities,
    Loyola University Chicago

    <br><br>

    <p class="text-gray-600">
        Licensed under Creative Commons Attribution 4.0 International License, {{ carbon()->format('Y') }}
    </p>
</div>
@endrouteIs

@routeIsnt('project.index')
<div class="text-center">
    <i>Dickinson's Birds: A Public Listening Project</i> &#169; {{ carbon()->format('Y') }}
    <br>
    <strong>Site under phase 1 development.</strong>

    <br><br>

    Support for this project has been provided by the Office of Research Services 
    and the Center for Textual Studies and Digital Humanities,
    Loyola University Chicago

    <br><br>

    <p class="text-gray-600">
        Licensed under Creative Commons Attribution 4.0 International License, {{ carbon()->format('Y') }}
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
