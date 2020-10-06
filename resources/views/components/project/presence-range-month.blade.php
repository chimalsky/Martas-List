@php
    $presence = collect(explode(',', $presence->value));
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
    {{ $arrival }} 
</span> --- 
<span>
    {{ $departure }}
</span>