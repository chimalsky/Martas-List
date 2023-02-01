@props(['bird', 'width', 'height'])

@if ($bird->xc_citation)
    @php 
        $xc_citation = $bird->xc_citation;

        $url = Str::afterLast($xc_citation->value, ' ');
        $url = Str::beforeLast($url, '.');
        $url = 'https://'.trim($url);
    @endphp

    <div {{ $attributes->merge(['class' => 'flex justify-center']) }}>
        <iframe src='{{ $url }}/embed' scrolling='no' frameborder='0' width='{{ $width }}' height='{{ $height }}' loading="lazy"></iframe>
    </div>
@endif 