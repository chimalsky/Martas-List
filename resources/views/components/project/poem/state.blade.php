<section {{ $attributes->merge(['class' => "flex justify-center space-x-4 max-w-lg mx-auto mt-8 text-sm italic"]) }}>
    <div class="inline-block">
        <img class="w-8 inline-block" src="{{ asset('img/lost-or-destroyed.png') }}" />
        <span>
            = Original manuscript lost or destroyed
        </span>
    </div>

    <div class="inline-block">
        <img class="w-6 inline-block" src="{{ asset('img/coming-soon.jpg') }}" />
        <span>
            = Manuscript facsimile coming soon
        </span>
    </div>
</section>