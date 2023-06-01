<div data-controller="nested-filter">
    @foreach ($filterable->optionsGrouped as $group)
        <section>
            @if ($group['_items'])
                <header>
                    <label data-nested-filter-target="block" class="cursor-pointer block mb-4 border border-gray-700 p-2"
                        data-block-name="{{ $group['_name'] }}">
                        <input data-action="click->nested-filter#blockSelected" 
                            @if (collect(request()->input('filterable.' . $filterable->id))->contains($group['_name']))
                                checked 
                            @endif
                            type="checkbox" class="hidden" name="filterable[{{ $filterable->id }}][]" value="{{ $group['_name'] }}" />
                        {{ $group['_name'] }} 
                    </label>
                </header>

                <main data-nested-filter-target="blockOptions" data-block="{{ $group['_name'] }}">
                    @foreach ($group['_items'] as $option)
                        <x-project.filter.input :filterable="$filterable" :option="$option" data-option data-block="{{ $group['_name'] }}"
                            data-action="click->nested-filter#optionSelected" />
                    @endforeach
                </main>
            @else 
                <main data-nested-filter-target="pseudoBlock">
                    <x-project.filter.button-input :filterable="$filterable" 
                        :option="$group['_name']" 
                        data-action="click->nested-filter#optionSelected" />
                </main>
            @endif
        </section>
    @endforeach

    <footer class="mt-4">
        <button type="button" data-action="click->nested-filter#back" data-nested-filter-target="back" class="block mb-4 border border-gray-700 p-2">
          ← Back
        </button>
    </footer>
</div>
