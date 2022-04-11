<?php

namespace App\Imports;

use App\Resource;
use App\ResourceType;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ResourcesImport implements ToCollection, WithHeadingRow
{
    public $resourceType;

    protected $resourceNameColumn;

    public function collection(Collection $rows)
    {
        $resourceType = $this->resourceType;

        $keys = collect($rows[0])->keys()->filter(function ($key) {
            return ! is_null($key) && $key;
        });

        $keys->each(function ($key) use ($resourceType) {
            $resourceType
                ->attributes()
                ->firstOrCreate(
                    ['key' => $key],
                    ['type' => 'default']
                );
        });

        $this->resourceNameColumn = $keys[1];

        $attributes = $resourceType->attributes()
            ->whereIn('key', $keys)->get();

        foreach ($rows as $index => $row) {
            if (is_null($row[$this->resourceNameColumn])) {
                continue;
            }

            $resource = $resourceType->resources()->firstOrCreate([
                'name' => $row[$this->resourceNameColumn],
            ]);

            foreach ($row as $header => $column) {
                if (is_null($column)) {
                    continue;
                }
                $resource->meta()->firstOrCreate(
                    ['key' => $header],
                    [
                        'value' => $column,
                        'resource_attribute_id' => $attributes->firstWhere('key', $header)->id,
                    ]
                );
            }
        }
    }
}
