<?php

use App\ResourceType;
use App\Project\Poem;

$poemType = ResourceType::find(Poem::$resource_type_id);

$envAttributeSpecific = $poemType->attributes()->firstOrCreate([
    'key' => 'New Specific Environmental Phenomena',
    'type' => 'default'
]);

$csv = fopen(('./nov-2022-env-tags.csv'), 'r');
$headers = null;
$empties = [];
$errors = [];

$indices = [
    'msId' => [0, 127]
];

while ($csvLine = fgetcsv($csv, 1000, ",")) {
    if (!$headers) {
        $headers = $csvLine;
    } else {
        $options = array_slice($csvLine, 2, 10);
        $uniqueIdValue = $csvLine[$indices['msId'][0]];
        $poem = Poem::withDynamicValue($indices['msId'][1], 'msId')
            ->whereHas('msId', function($query) use ($uniqueIdValue) {
                $query->where('value', $uniqueIdValue);
            })->first();

        $categoriesValue = collect([]);

        if (!$poem) {
            array_push($empties, [$csvLine[0], $csvLine[1]]);
            continue;
        }

        $specific = explode(';', $csvLine[11]);

        foreach($specific as $s) {
            if (!$s) {
                continue;
            }
            $poem->meta()->updateOrCreate([
                'resource_attribute_id' => $envAttributeSpecific->id,
                'value' => $s
            ]);
        }

        /*foreach($categoriesValue as $value) {
            $poem->meta()->updateOrCreate([
                'resource_attribute_id' => $envAttributeCategory->id,
                'value' => $value
            ]);
        }

        $specific = $poem->meta()->updateOrCreate(
            ['resource_attribute_id' => $envAttributeSpecific->id],
            ['value' => $csvLine[11]]
        );*/     
    }
}

dump($headers);
dump($empties);
dump($errors);
