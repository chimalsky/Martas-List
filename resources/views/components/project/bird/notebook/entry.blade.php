@php
    $noSmallCaps = $noSmallCaps ?? false;
    $words = explode(' ', $header);
@endphp

<div class="mb-12">
    <header style="color: #B45F06" class="text-md mb-6">
        @unless($noSmallCaps)
            @foreach ($words as $word)
            <span class="text-2xl">
                {{ strtoupper(substr($word, 0, 1)) }}</span>{{ strtoupper(substr($word, 1)) }}
            @endforeach
        @else 
            <span class="text-2xl">
                {{ $header }}
            </span>
        @endunless
    </header>
    <main {{ $attributes->merge(['class' => "pl-6 text-sm italic"]) }}>
        @isset($data)
            {{ optional($data)->value ?? 'Unknown' }}
        @endisset 

        {{ $slot }}
    </main>
</div>
