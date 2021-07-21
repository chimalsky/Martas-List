<button class="border border-gray-600 p-2" {{ $attributes->whereStartsWith('data') }}>
    {{ $slot }}
</button>