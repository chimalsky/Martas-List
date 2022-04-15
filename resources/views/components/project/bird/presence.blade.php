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

    if ($bird) {
        $occurence = $bird->firstMetaByAttribute($occurenceIds[$century]);
        $presence = $bird->firstMetaByAttribute($presenceIds[$century]);
    } else {
        $hardcodedOccurenceIds = [
            19 => 651,
            20 => 671,
            21 => 653
        ];
        $occurence = $primaryBird->firstMetaByAttribute($hardcodedOccurenceIds[$century]);
        $presence = null;
    }

    if ($bird && $century == 19 && !$occurence) {
        $occurence = $bird->firstMetaByAttribute(544);
    }

@endphp

<div {{ $attributes }}>
    <header style="color: #B45F06; font-family: Cormorant SC; font-style: normal;" class="text-2xl">
        C{{ $century }}
    </header> 
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
    @else
            <p>
                No data available
            </p>
    @endif 

    @if(!isset($hideOccurence))
        @if ($occurence)
            <p style="font-style: normal;">
                {{ trim($occurence->value) }}
            </p>
        @endif
    @endif
    @if ($presence)
        @foreach ($stints as $stint)
            @php
                $arrival = date("F", mktime(0, 0, 0, $stint->first(), 1));
                $departure = date("F", mktime(0, 0, 0, $stint->last(), 1));
            @endphp
            <p class="text-center italic">
                @if ($arrival == $departure)
                    {{ $arrival }}
                @else 
                    {{ $arrival }} - {{ $departure }}
                @endif
            </p>
        @endforeach
    @endif
</div>
