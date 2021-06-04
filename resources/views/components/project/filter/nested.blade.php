<div data-controller="nested-filter">
    @foreach ($filterable->optionsGrouped as $group)
        <section>
            <header>
                <label data-nested-filter-target="block" class="block mb-4 border border-gray-700 p-2"
                    data-block-name="{{ $group['_name'] }}">
                    <input data-action="change->form#changed click->nested-filter#blockSelected" 
                        @if (collect(request()->input('filterable.' . $filterable->id))->contains($group['_name']))
                            checked 
                        @endif
                        type="checkbox" class="hidden" name="filterable[{{ $filterable->id }}][]" value="{{ $group['_name'] }}" />
                    {{ $group['_name'] }} 
                </label>
            </header>

            <main data-nested-filter-target="blockOptions" data-block="{{ $group['_name'] }}">
                @foreach ($group['_items'] as $option)
                    <x-project.filter.input :filterable="$filterable" :option="$option" 
                        data-action="change->form#changed click->nested-filter#optionSelected" />
                @endforeach
            </main>
        </section>
    @endforeach

    <button type="button" data-action="click->nested-filter#back" data-nested-filter-target="back">
        <- Back
    </button>
</div>
