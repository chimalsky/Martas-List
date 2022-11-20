use App\ResourceType;
use App\Project\Poem;
use App\ResourceAttribute;

$poemType = ResourceType::find(Poem::$resource_type_id);
$envAttributeCategory = $poemType->attributes()->firstOrCreate([
    'key' => 'New Category Environmental Phenomena',
    'type' => 'default'
]);
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
        $envAttributeCategory->update(['options' => array_slice($headers, 2, 8)]);
    } else {
        $options = array_slice($csvLine, 2, 8);
        $uniqueIdValue = $csvLine[$indices['msId'][0]];
        $poem = Poem::withDynamicValue($indices['msId'][1], 'msId')
            ->whereHas('msId', function($query) use ($uniqueIdValue) {
                $query->where('value', $uniqueIdValue);
            })->first();

        $categoriesValue = collect([]);

        foreach ($options as $key => $value) {
            if ($value == 'YES') {
                $categoriesValue->push($headers[$key+2]);
            }
        }

        if (!$poem) {
            array_push($empties, [$csvLine[0], $csvLine[1]]);
            continue;
        }

        foreach($categoriesValue as $value) {
            $poem->meta()->updateOrCreate([
                'resource_attribute_id' => $envAttributeCategory->id,
                'value' => $value
            ]);
        }

        $specific = $poem->meta()->updateOrCreate(
            ['resource_attribute_id' => $envAttributeSpecific->id],
            ['value' => $csvLine[11]]
        );        
    }
}

$envAttributeCategory->update(['visibility' => 1]);
dump($envAttributeCategory);

dump($headers);
dump($empties);
dump($errors);
