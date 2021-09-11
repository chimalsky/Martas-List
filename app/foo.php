$csv = fopen(storage_path('app/e-tags.csv'), 'r');
$headers = null;
$empties = [];
$errors = [];

$attributes =  \App\ResourceType::find(3)->attributes;

function handleExistence($cell, $poem, $attribute) {
  $values = explode(';', $cell);
  
}

while ($csvLine = fgetcsv($csv, 1000, ",")) {
    if (!$headers) {
        $headers = $csvLine;
    } else {
        $msId = explode(',', $csvLine[0])[0];
      
        $poem = \App\Project\Poem::whereHas('msId', function($q) use ($msId) {
			$q->where('value', $msId);
        })->first();
      
      	if (!$poem) {
          array_push($empties, $csvLine[0]);
          continue;
        }
      
      	foreach ($csvLine as $index => $cell) {
          $key = $headers[$index];
          
          $attribute = $attributes->firstWhere('key', $key);
          
          if (!$attribute) {
            continue;
          }
          
          $poem->meta()->where('resource_attribute_id', $attribute->id)->delete();

          
          if ($cell == 'x') {
            continue;
          }
          
          $values = explode(';', $cell);
          
          foreach($values as $value) {
            if ($value == '' || $value == ' ') {
              contineu;
            }
            
            $poem->meta()->create([
              'resource_attribute_id' => $attribute->id,
              'value' => trim(ucfirst($value));
            ]);
          }
        }
    }
}


dump($empties);
dump($errors);