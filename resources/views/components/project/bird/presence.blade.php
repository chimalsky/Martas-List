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
            $stints = collect(explode(';', $presence->value));

            $stints = $stints->map(function($stint) {
                return collect(explode(',', $stint))
                    ->map(function($month) { 
                        return (int) $month; 
                    });
                });
        }
    @endphp 
    
    <div {{ $attributes }}>
        @unless (isset($hideCentury))
            <p class="not-italic">
                @if ($century != 21)
                    {{ $century }}th.
                @else
                    {{ $century }}st.
                @endif
                Century
            </p> 
        @endif
        @if ($occurence && !isset($hideOccurence))
            <p class="italic">
                {{ trim($occurence->value) }};
            </p>
        @endif

        @if ($presence)
            @foreach ($stints as $stint)
                @php
                    $arrival = date("F", mktime(0, 0, 0, $stint->first(), 1));
                    $departure = date("F", mktime(0, 0, 0, $stint->last(), 1));
                @endphp
                <p class="text-center mt-2 italic">
                    @if ($arrival == $departure)
                        {{ $arrival }}
                    @else 
                        {{ $arrival }} - {{ $departure }}
                    @endif
                </p>
            @endforeach
        @endif
    </div>
@endif