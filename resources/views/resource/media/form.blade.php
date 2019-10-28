<input type="file" name="media" />

<section class="flex flex-wrap">
    <label class="w-full my-2">
        Name
        {{ html()->text('name')->class(['form-input']) }}
    </label>

    <label class="w-full my-2">
        Date
        {{ html()->input('date')->class('') }}
    </label>

    <label class="w-full my-2">
        Time
        {{ html()->text('time')->class(['form-input']) }}
    </label>

    <label class="w-full my-2">
        Location
        {{ html()->text('location')->class(['form-input']) }}
    </label>

    <label class="w-full my-2">
        Sound Type
        {{ html()->text('sound_type')->class(['form-input']) }}
    </label>

    <label class="w-full my-2">
        Background Sounds 
        {{ html()->text('background_sounds')->class(['form-input']) }}
    </label>

    <label class="w-full my-2">
        Citation
        {{ html()->text('citation')->class(['form-input']) }}
    </label>

</section>