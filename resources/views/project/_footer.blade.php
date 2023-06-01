<div class="text-center text-sm">
    <p>
        <i>Dickinson’s Birds</i> &#169; {{ carbon()->format('Y') }} <br/>
        Marta Werner, Abe Kim, Caroline McCraw, and Danielle Richards, with Will Sikich
    </p>

    <p class="text-gray-600 mt-1">
        Licensed under Creative Commons Attribution 4.0 International License, {{ carbon()->format('Y') }}
    </p>

    <p class="text-gray-600 mt-2">
        Web development and hosting by Abe Kim
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
