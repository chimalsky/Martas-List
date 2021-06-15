@props(['bird'])

@if ($bird->xc_citation)
    @php 
        $xc_citation = $bird->xc_citation;

        $url = Str::afterLast($xc_citation->value, ' ');
        $url = Str::beforeLast($url, '.');
        $url = 'https://'.trim($url);
    @endphp

    <div {{ $attributes->merge(['class' => 'flex justify-center']) }}>
        <iframe src='{{ $url }}/embed' scrolling='no' frameborder='0' width='340' height='220' loading="lazy"></iframe>
    </div>
@endif 