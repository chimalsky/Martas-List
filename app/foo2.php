<?php

$csv = fopen(storage_path('app/e-tags.csv'), 'r');
$blocks = null;
$empties = [];
$foo = collect();

$attribute = \App\ResourceAttribute::find(632);

while ($csvLine = fgetcsv($csv, 1000, ',')) {
    if (! $blocks) {
        $blocks = collect(array_slice($csvLine, 1, -1))->map(function ($block) {
            return [
                '_name' => $block,
                '_items' => [],
            ];
        });
    } else {
        $msId = explode(',', $csvLine[0])[0];

        $poem = \App\Project\Poem::whereHas('msId', function ($q) use ($msId) {
            $q->where('value', $msId);
        })->first();

        if (! $poem) {
            array_push($empties, $csvLine[0]);
            continue;
        }

        $poem->meta()->where('resource_attribute_id', $attribute->id)->delete();

        foreach (array_slice($csvLine, 1, -1) as $index => $cell) {
            if ($cell == 'x') {
                continue;
            }

            $values = explode(';', $cell);

            foreach ($values as $value) {
                if ($value == '' || $value == ' ') {
                    continue;
                }

                $value = ucfirst(strtolower(trim($value)));

                if (! in_array($value, $blocks[$index]['_items'])) {
                    $blocks[$index] = [
                        '_name' => $blocks[$index]['_name'],
                        '_items' => array_merge($blocks[$index]['_items'], [$value]),
                    ];
                }

                $poem->meta()->create([
                    'resource_attribute_id' => $attribute->id,
                    'value' => $value,
                ]);
            }
        }
    }
}

dump($blocks);
dump($empties);

$attribute->update([
    'options' => $blocks,
]);
