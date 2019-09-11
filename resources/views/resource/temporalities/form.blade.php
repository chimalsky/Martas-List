<label class="block mb-8">
    Name of Temporality
    
    {{ html()->text('name')->class('form-input')->placeholder('examples: Arrival, Departure, Etc') }}
</label>

<h1 class="font-bold">
    Temporal Range
</h1>
<label class="flex flex-wrap mb-8">
    {{ html()->input('date', 'date-range')->class('w-1/2') }}
</label>

<label>
    Start Precision

    {{ 
        html()->select('start_precision', [
            null => '---',
            1 => 'Low -- We know the Year',
            2 => 'Medium -- We know the Month', 
            3 => 'High -- We know the Week',
            4 => 'Super -- We know the Day'
        ])->class('form-select')
    }}
</label>


<label>
    End Precision

    {{ 
        html()->select('end_precision', [
            null => '---',
            1 => 'Low -- We know the Year',
            2 => 'Medium -- We know the Month', 
            3 => 'High -- We know the Week',
            4 => 'Super -- We know the Day'
        ])->class('form-select')
    }}
</label>