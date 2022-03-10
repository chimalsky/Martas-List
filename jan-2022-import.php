<?php
use App\ResourceAttribute;
use App\Project\Bird;
use App\ResourceMeta;

$csv = fopen(storage_path('app/birdring-2022-jan.csv'), 'r');
$headers = null;
$empties = [];
$errors = [];

$indices = [
  'audioFileId' => [1, 684],
  'speciesId' => [2, 499],
  'residenceStatus' => [4, 685],
  'appearance' => [5, 686],
  'xcLink' => [9, 502],
  'presence' => [10, 688],
  'presenceCitation' => [11, 689],
  'arrival' => [12, 690],
  'departure' => [13, 691]
];

while ($csvLine = fgetcsv($csv, 1000, ",")) {
    if (!$headers) {
        $headers = $csvLine;
    } else {
      $uniqueIdValue = $csvLine[$indices['speciesId'][0]];
      $bird = Bird::withDynamicValue($indices['speciesId'][1], 'speciesId')
          ->whereHas('universalSpeciesId', function($query) use ($uniqueIdValue) {
            $query->where('value', $uniqueIdValue);
          })->first();
      
      if (!$bird) {
          array_push($empties, $csvLine[$indices['speciesId'][0]]);
          continue;
      }
      
      $attribute = $indices['audioFileId'][1];
      $value = $csvLine[$indices['audioFileId'][0]];
      
      $audio = $bird->meta()->updateOrCreate(
          ['resource_attribute_id' => $attribute],
          ['value' => $value]
      );
           
      $attribute = $indices['residenceStatus'][1];
      $value = $csvLine[$indices['residenceStatus'][0]];
            
      $residenceStatus = $bird->meta()->updateOrCreate(
          ['resource_attribute_id' => $attribute],
          ['value' => $value]
      );
           
      $attribute = $indices['appearance'][1];
      $value = $csvLine[$indices['appearance'][0]];
           
      $appearance = $bird->meta()->updateOrCreate(
          ['resource_attribute_id' => $attribute],
          ['value' => $value]
      );
      
      $attribute = $indices['xcLink'][1];
      $value = $csvLine[$indices['xcLink'][0]];
           
      $xcLink = $bird->meta()->updateOrCreate(
          ['resource_attribute_id' => $attribute],
          ['value' => $value]
      );
      
      $attribute = $indices['presence'][1];
      $value = $csvLine[$indices['presence'][0]];
           
      $presence = $bird->meta()->updateOrCreate(
          ['resource_attribute_id' => $attribute],
          ['value' => $value]
      );
      
      $attribute = $indices['presenceCitation'][1];
      $value = $csvLine[$indices['presenceCitation'][0]];
           
      $presenceCitation = $bird->meta()->updateOrCreate(
          ['resource_attribute_id' => $attribute],
          ['value' => $value]
      );
      
      $attribute = $indices['arrival'][1];
      $value = $csvLine[$indices['arrival'][0]];
           
      $arrival = $bird->meta()->updateOrCreate(
          ['resource_attribute_id' => $attribute],
          ['value' => $value]
      );
      
      $attribute = $indices['departure'][1];
      $value = $csvLine[$indices['departure'][0]];
           
      $departure = $bird->meta()->updateOrCreate(
          ['resource_attribute_id' => $attribute],
          ['value' => $value]
      );
    }
}

dump($headers);
dump($empties);
dump($errors);
