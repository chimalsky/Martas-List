@if ($errors->any())
    <div class="bg-red-200 p-2 my-2">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<label class="w-full px-2">
    <span class="text-gray-700">Unique ID Library MS number / underscore / Variorum Number and
        Letter / underscore / TS (“Transcript”) or MS (“Manuscript”)</span>

    {{ html()->text('encoder_assigned_id')->class(['form-input', 'mt-1', 'block', 'w-full']) }}
</label>