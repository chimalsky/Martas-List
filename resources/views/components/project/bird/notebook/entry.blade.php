@php
    $noSmallCaps = $noSmallCaps ?? false;
    $words = explode(' ', $header);
@endphp

<div class="mb-12">
    <header style="color: #B45F06; font-family: Cormorant SC;" class="text-3xl mb-6">
        {{ $header }}
    </header>
    <main {{ $attributes->merge(['class' => "text-sm italic"]) }}>
        @isset($data)
            {{ optional($data)->value ?? 'Unknown' }}
        @endisset 

        {{ $slot }}
    </main>
</div>
