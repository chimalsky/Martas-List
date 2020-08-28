<div>
    <header class="block text-md text-center hover:underline mb-3 text-red-800 font-serif">
        {{ $bird->name }}
    </header>

    @php 
        $xc_citation = $bird->metaByAttribute(502)->first()->value;
        $url = Str::afterLast($xc_citation, ' ');
        $url = Str::beforeLast($url, '.');
        $url = 'https://'.trim($url);
    @endphp

    <iframe src='{{ $url }}/embed' scrolling='no' frameborder='0' width='340' height='220'></iframe>
</div>