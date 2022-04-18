<div class="text-center text-sm">
    <p class="mb-1">
        <i>Dickinson’s Birds</i> &#169; {{ carbon()->format('Y') }}
    </p>

    <p class="text-gray-600">
        Web development and hosting by Abe Kim
    </p>

    <p class="mt-4">
        Support for this project has been provided by the Office of Research Services 
        and the Center for Textual Studies and Digital Humanities,
        Loyola University Chicago.
    </p>

    <p class="text-gray-600">
        Licensed under Creative Commons Attribution 4.0 International License, {{ carbon()->format('Y') }}
    </p>
</div>

@routeIsnt('project.index')
<div class="block mt-12 text-right">
    @auth
        <a href="{{ route('resource-types.index') }}" class="no-underline hover:underline text-sm font-normal text-teal-800">Go to Archiver</a>
    @else
        <a href="{{ route('login') }}" class="no-underline hover:underline text-sm font-normal text-teal-800 pr-6">{{ __('Login') }}</a>
    @endauth
</div>
@endrouteIsnt('project.index')
