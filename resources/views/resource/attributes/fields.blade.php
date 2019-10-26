@if ($resource) 
    @if ($attribute->type == 'rich-text')
        {{ html()->hidden("attribute[" . $attribute->name . "]", $resource->mainMeta->firstWhere('key', $attribute->name)->value ?? null)->attribute('id', $attribute->name) }}
        <trix-editor input="{{ $attribute->name }}"></trix-editor>

    @elseif ($attribute->type == 'encoding')
        <h1 class="font-semibold">
            Mock Encoding -- textbox is resizable as needed from bottom-right corner
        </h1>

        {{ html()->textarea("attribute[" . $attribute->name . "]", $resource->mainMeta->firstWhere('key', $attribute->name)->value ?? null)
            ->class(['w-full', 'block', 'border', 'border-2', 'border-black'])
            ->attribute('id', $attribute->key)
        }}

    @elseif ($attribute->type == 'temporality')
        <h1 class="text-semibold">
            {{ $attribute->key }}
        </h1>

        <div class="block">
            <input type="date" class="date-element" name="attribute[ {{ $attribute->name }} ]" 
            value="{{ $resource->mainMeta->firstWhere('key', $attribute->name)->value ?? null }}" />
        </div>
    @elseif ($attribute->type == 'link')
        {{ html()->text("attribute[" . $attribute->name . "]", $resource->mainMeta->firstWhere('key', $attribute->name)->value ?? null)
            ->class(['form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}

        @if ($resource->mainMeta->firstWhere('key', $attribute->name))
            <a href="{{ $resource->mainMeta->firstWhere('key', $attribute->name)->value }}"
                class="text-right">
                {{ $resource->mainMeta->firstWhere('key', $attribute->name)->value }}
            </a>
        @endif
    @else
        {{ html()->text("attribute[" . $attribute->key . "]", $resource->mainMeta->firstWhere('key', $attribute->key)->value ?? null)
            ->class(['form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}
    @endif
@else
    @if ($attribute->type == 'rich-text')
        {{ html()->hidden("attribute[" . $attribute->name . "]")->attribute('id', $attribute->key) }}
        <trix-editor input="{{ $attribute->name }}"></trix-editor>
    @elseif ($attribute->type == 'encoding')
        <h1 class="font-semibold">
            Mock Encoding -- textbox is resizable as needed from bottom-right corner
        </h1>

        {{ html()->textarea("attribute[" . $attribute->name . "]")
            ->class(['w-full', 'block', 'border', 'border-2', 'border-black'])
            ->attribute('id', $attribute->key)
        }}

    @elseif ($attribute->type == 'temporality')
        <h1 class="text-semibold">
            {{ $attribute->key }}
        </h1>

        <div class="block">
            <input type="date" class="date-element" name="attribute[ {{ $attribute->name }} ]" value="{{ $attribute->value }}" />
        </div>
    @else
        {{ html()->text("attribute[" . $attribute->key . "]")
            ->class(['form-input', 'mt-1', 'block', 'w-full', 'font-medium']) }}
    @endif
@endif
