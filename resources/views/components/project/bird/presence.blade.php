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
        $punctuation = '.';

        if ($presence) {
            $presence = collect(explode(',', $presence->value));
            $presence = $presence->map(function($month) { return (int) $month; });

            $arrival = date("F", mktime(0, 0, 0, $presence->first(), 1));
            $departure = date("F", mktime(0, 0, 0, $presence->last(), 1));

            $punctuation = ';';
        }
    @endphp 
    
    <div {{ $attributes }}>
        <p class="not-italic">
            @if ($century != 21)
                {{ $century }}th.
            @else
                {{ $century }}st.
            @endif
            Century
        </p> 
        @if ($occurence)
            <p class="italic">
                {{ trim($occurence->value).$punctuation }}
            </p>
        @endif

        @if ($presence)
            <p class="text-right mt-2 italic">
                {{ $arrival }} - {{ $departure }}
            </p>
        @endif
    </div>
@endif