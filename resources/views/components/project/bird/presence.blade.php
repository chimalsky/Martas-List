@php
    $occurenceIds = [
        19 => 535,
        20 => 562,
        21 => 571
    ];

    $presenceIds = [
        19 => 538,
        20 => 565,
        21 => 574
    ];

    $occurence = $bird->firstMetaByAttribute($occurenceIds[$century]);
    $presence = $bird->firstMetaByAttribute($presenceIds[$century]);
@endphp

@if ($occurence || $presence)
    @php
        if ($presence) {
            $presence = collect(explode(',', $presence->value));
            $presence = $presence->map(function($month) { return (int) $month; });

            $arrival = date("F", mktime(0, 0, 0, $presence->first(), 1));
            $departure = date("F", mktime(0, 0, 0, $presence->last(), 1));
        }
    @endphp 
    
    <div {{ $attributes->merge(['class' => 'text-lg']) }}>
        <span class="font-bold">
            @if ($century != 21)
                {{ $century }}th.
            @else
                {{ $century }}st.
            @endif
            Century
        -</span> 
        @if ($occurence)
            {{ $occurence->value }};
        @endif

        @if ($presence)
            <p class="text-right mt-2">
                {{ $arrival }} - {{ $departure }}
            </p>
        @endif
    </div>
@endif