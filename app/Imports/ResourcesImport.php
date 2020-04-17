<?php

namespace App\Imports;

use App\Resource;
use App\ResourceType;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ResourcesImport implements ToCollection, WithHeadingRow
{
    public $resourceType;

    public function collection(Collection $rows)
    {
        $resourceType = $this->resourceType; 

        $keys = collect($rows[0])->keys()->filter(function($key) { return $key; });

        $keys->each(function($key) use ($resourceType) {
            $resourceType
                ->attributes()
                ->firstOrCreate(
                    ['key' => $key],
                    ['type' => 'default']
                );
        });        

        $attributes = $resourceType->attributes;

        foreach ($rows as $index => $row) 
        {
            if (!$row['name_common']) {
                continue;
            }

            $resource = $resourceType->resources()->firstOrCreate([
                'name' => $row['name_common']
            ]);
        }
    }
}
