@php
    $months = collect($filterable->options)->filter(function($option) {
        return collect([
            'january',
            'february',
            'march',
            'april',
            'may',
            'june',
            'july',
            'august',
            'september',
            'october',
            'november',
            'december'
        ])->contains(strtolower($option));
    });

    $seasons = collect($filterable->options)->filter(function($option) {
        return collect([
            'winter',
            'spring',
            'summer',
            'fall'
        ])->contains(strtolower($option));
    });

    $seasons = $seasons->map(function($season) {
        switch ($season) {
            case 'winter':
                $values = ['December', 'January', 'February'];
                break;
            case 'spring':
                $values = ['March', 'April', 'May'];
                break;
            case 'summer':
                $values = ['June', 'July', 'August'];
                break;
            case 'fall':
                $values = ['September', 'October', 'November'];
        }

        return ['name' => $season, 'months' => $values];
    })
@endphp

<div class="">
    @foreach ($seasons as $season)
        <section class="w-full mb-4">
            <span class="italic">
                {{ $season['name'] }}
            </span>
            
            <main class="pl-4">
                @foreach ($season['months'] as $month) 
                <label class="cursor-pointer block">
                    <input data-action="change->form#changed" type="checkbox"
                        name="filterable[{{ $filterable->id }}][]"
                        value="{{ $month }}"
                        class=""
                        @if (collect(request()->input('filterable.' . $filterable->id))->contains($month))
                            checked 
                        @endif
                        autocomplete="off" 
                            />
                    <span class="pl-2">
                        {{ $month }} 
                    </span>
                @endforeach
            </main>
        </section>
    @endforeach
</div>