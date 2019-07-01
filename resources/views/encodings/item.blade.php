<div class="w-1/3 p-4">
    <article class="bg-green-200 p-4">
        <a href="{{ route('encodings.edit', $encoding) }}">
            {{ $encoding->encoder_assigned_id }}
        </a>

        <p class="mt-4 text-right">
            Created: 
                <span data-controller="date" data-date-datetime="{{ $encoding->created_at }}">
                    {{ $encoding->created_at }}
                </span>
        </p>

        <aside class="flex justify-end mt-2">
            <a href="{{ route('encodings.edit', $encoding) }}"
                class="btn btn-hollow">
                Edit
            </a>
        </aside>
    </article>
</div>