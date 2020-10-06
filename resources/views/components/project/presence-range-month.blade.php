@php
    $presence = collect(explode(',', preg_replace('/\xc2\xa0/', '', $presence->value)));
    $presence = $presence->map(function($month) { return (int) $month; });

    $arrival = \App\Project\MonthEnum::getConstantNameByValue($presence->first());  
    $departure = \App\Project\MonthEnum::getConstantNameByValue($presence->last());  
@endphp 

@isset ($header)
<header class="font-bold">
    {{ $header }}
</header> 
@endisset

<span>
    {{ Str::title($arrival) }} 
</span> --- 
<span>
    {{ Str::title($departure) }}
</span>