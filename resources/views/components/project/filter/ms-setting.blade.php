<div x-data="{stage: 0, type:null}">
<section id="parent-options" x-show="stage === 0">
    <label class="block mb-4 border border-gray-700 p-2">
        <input data-action="change->form#changed" @click="stage = 1; type = 'bound';" x-ref="bound" 
            @suboption-selected.window="if ($refs.bound.checked) $refs.bound.click();"
            @if (collect(request()->input('filterable.' . $filterable->id))->contains('Bound'))
                checked 
            @endif
            type="checkbox" class="hidden" name="filterable[{{ $filterable->id }}][]" value="Bound" />
        Bound 
    </label>
    <label class="block mb-4 border border-gray-700 p-2">
        <input data-action="change->form#changed" @click="stage = 1; type = 'unbound';" x-ref="unbound"
            @suboption-selected.window="if ($refs.unbound.checked) $refs.unbound.click();"
            @if (collect(request()->input('filterable.' . $filterable->id))->contains('Unbound'))
                checked 
            @endif
            type="checkbox" class="hidden" name="filterable[{{ $filterable->id }}][]" value="Unbound" />
        Unbound
    </label>
    <label>
        <input data-action="change->form#changed" x-ref="unknown" class="-ml-4"
            @if (collect(request()->input('filterable.' . $filterable->id))->contains('Unknown'))
                checked 
            @endif
            type="checkbox" name="filterable[{{ $filterable->id }}][]" value="Unknown" />
        Unbound
    </label>
</section>
<section x-show="stage === 1" id="suboptions" >
    @php 
        $boundOptions = $filterable->nonNullOptions->filter(function($option) { return Str::contains($option, 'fascicle'); });
        $unboundOptions = $filterable->nonNullOptions->reject(function($option) { return Str::contains($option, 'fascicle') || in_array($option, ['Unknown', 'Bound', 'Unbound']); });
    @endphp
    <div x-show="type == 'bound'" 
        @back.window="document.querySelectorAll('#suboptions input').forEach(e => { console.log(e); if (!e.checked) { return; }  e.click()})">
        <header class="text-lg mb-4">
            Bound Settings
        </header>

        @foreach ($boundOptions as $option) 
            <label class="block cursor-pointer">
                <input data-action="change->form#changed" 
                    @click="$dispatch('suboption-selected')"
                    type="checkbox"
                    name="filterable[{{ $filterable->id }}][]"
                    value="{{ $option }}"
                    class=""
                    @if (collect(request()->input('filterable.' . $filterable->id))->contains($option))
                        checked 
                    @endif
                    autocomplete="off" 
                        />
                <span class="pl-2">
                    {{ $option }}
                </span>
            </label>
        @endforeach 
    </div>
    <div x-show="type == 'unbound'">
        <header class="text-lg mb-4">
            Unbound Settings
        </header>
        @foreach ($unboundOptions as $option) 
            <label class="block cursor-pointer">
                <input data-action="change->form#changed" 
                    @click="$dispatch('suboption-selected')"
                    type="checkbox"
                    name="filterable[{{ $filterable->id }}][]"
                    value="{{ $option }}"
                    class=""
                    @if (collect(request()->input('filterable.' . $filterable->id))->contains($option))
                        checked 
                    @endif
                    autocomplete="off" 
                        />
                <span class="pl-2">
                    {{ $option }}
                </span>
            </label>
        @endforeach 
    </div>

    <button type="button" @click="stage = 0; $dispatch('back');" class="mt-4">
        < Back 
    </button>
</section>
</div>