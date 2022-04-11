<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citation extends Model
{
    protected $guarded = [];

    /**
     * @param string|array|\ArrayAccess $values
     * @param string|null $type
     *
     * @return \Spatie\Tags\Tag|static
     */
    public static function findOrCreate($values, string $type = null)
    {
        $citations = collect($values)->map(function ($value) use ($type) {
            if ($value instanceof self) {
                return $value;
            }

            return static::findOrCreateFromString($value);
        });

        return is_string($values) ? $citations->first() : $citations;
    }

    public static function findFromString(string $citation)
    {
        return static::query()
            ->where('citation', $citation)
            ->first();
    }

    protected static function findOrCreateFromString(string $citationString)
    {
        $citation = static::findFromString($citationString);

        if (! $citation) {
            $citation = static::create([
                'citation' => $citationString,
            ]);
        }

        return $citation;
    }
}
