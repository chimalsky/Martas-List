<div>
    <header class="block text-2xl text-center hover:underline mb-3">
        {{ $bird->name }}
    </header>

    @php 
        $xc_citation = $bird->metaByAttribute(502)->first();
    @endphp

    @if($xc_citation)

        @php
            $url = Str::afterLast($xc_citation->value, ' ');
            $url = Str::beforeLast($url, '.');
            $url = 'https://'.trim($url);
        @endphp

        <iframe src='{{ $url }}/embed' scrolling='no' frameborder='0' width='340' height='220'></iframe>
    @endif
</div>