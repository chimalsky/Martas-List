@php
    $words = explode(' ', $header);
@endphp

<div class="mb-12">
    <header style="color: #B45F06" class="text-sm mb-6">
        @foreach ($words as $word)
        <span class="text-xl">
            {{ strtoupper(substr($word, 0, 1)) }}</span>{{ strtoupper(substr($word, 1)) }}
        @endforeach
    </header>
    <main class="pl-6 italic text-lg">
        @isset($data)
            {{ optional($data)->value ?? 'Unknown' }}
        @endisset 

        {{ $slot }}
    </main>
</div>
