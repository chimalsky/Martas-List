<div x-data="{ open: false, openCitation: false }"
    class="block pb-10 flex align-top">
    <section class="flex-auto" data-controller="resource-meta">

        @if ($meta->type == 'default' || !$meta->type)
            {{ html()->text("attribute[id-" . $meta->id . "]", $meta->value ?? null)
                ->class(['attribute', 'form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}
        @elseif ($meta->type == 'dropdown')
            {{ html()->select("attribute[id-" . $meta->id . "]", $attribute->optionsDropdown, $meta->value ?? null)
                ->class(['attribute', 'form-dropdown', 'mt-1', 'block', 'w-full', 'font-medium']) }}
        @elseif ($meta->type == 'link')
            {{ html()->text("attribute[id-" . $meta->id . "]", $meta->value ?? null)
                ->attribute('data-target', 'link')
                ->class(['attribute', 'form-input', 'mt-1', 'w-full', 'font-medium']) }}
        @elseif ($meta->type == 'external-media__image')
            <img src="{{ $meta->value }}" 
                class="object-none mb-2" />
        @elseif ($meta->type == 'external-media__audio')
            <audio controls class="my-2"
                src="{{ $meta->value }}">
                    Your browser does not support the
                    <code>audio</code> element.
            </audio>
        @endif

        @if ($meta->citations()->exists())
            <div class="block ml-4 font-mono">
                -- {{ $meta->citations->first()->citation }} 
            </div>
        @endif
    </section>

    <aside class="flex-none ml-2 relative">
        <button type="button" class="border-2 border-gray-500 p-2 relative"
            @click="open = !open">
            ---
        </button>

        <section x-show="open" @click.away="open = false" class="absolute right-0 p-4 bg-gray-300 text-gray-900 z-50">
            <main class="mb-6">
                @unless ($meta->citations()->exists())
                    <button type="button" class="border-2 border-gray-500 p-2 relative"
                        @click="openCitation = !openCitation"
                        x-show="!openCitation">
                        Add Citation
                    </button>
                @endunless

                <section x-show="openCitation" class="">
                    {{ html()->text("attributeCitation[id-" . $meta->id . "]", $meta->citation->citation ?? null)
                        ->placeholder('citation')
                        ->class(['citation', 'form-input', 'font-mono', 'border', 'border-black', 'mt-1', 'mb-4',
                            'block', 'font-medium']) }}

                    <button class="btn btn-blue">
                        Save Citation 
                    </button>
                </section>
            </main>

            <footer class="flex justify-end">
                <button wire:click="deleteMeta({{ $meta->id }})" 
                    wire:loading.class="opacity-50 cursor:not-allowed" 
                    wire:loading.attr="disabled"
                    class="btn btn-red mt-1 cursor-pointer" type="button">
                    Delete
                </button>

                <div wire:loading wire:target="deleteMeta"
                    class="mx-2">
                    Deleting 
                </div>
            </footer>
        </section>
    </aside>

</div>

@if ($meta->type == 'link' && $meta->value)
    <a href="{{ $meta->value }}"
        class="block mb-2">
    
        {{ $meta->value }}
    </a>
@endif