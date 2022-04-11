<?php

namespace App\Traits;

use App\Citation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasCitations
{
    protected $queuedCitations = [];

    public static function bootHasCitations()
    {
        static::created(function (Model $citeableModel) {
            if (count($citeableModel->queuedCitations) > 0) {
                $queued = $citeableModel->queuedCitations;

                $citeableModel->attachCitations($queued);
                $citeableModel->queuedCitations = [];
            }
        });

        static::deleted(function (Model $deletedModel) {
            $citations = $deletedModel->citations()->get();
            //$deletedModel->detachCitations($citations);
        });
    }

    public function citations(): MorphToMany
    {
        return $this->morphToMany(Citation::class, 'citeable');
    }

    public function attachCitation($citation)
    {
        return $this->attachCitations([$citation]);
    }

    /**
     * @param array|\ArrayAccess|\Spatie\Tags\Tag $tags
     *
     * @return $this
     */
    public function attachCitations($citations)
    {
        // This one bugs out for update/store for different reasons. weird
        // interaction with how collections work.
        $citations = Citation::findOrCreate($citations);
        $this->citations()->sync(isset($citations->id) ? $citations->id : $citations->pluck('id')->toArray());

        return $this;
    }

    /**
     * @param array|\ArrayAccess|\Spatie\Tags\Tag $tags
     *
     * @return $this
     */
    public function attachTags($tags)
    {
        $className = static::getTagClassName();
        $tags = collect($className::findOrCreate($tags));
        $this->tags()->syncWithoutDetaching($tags->pluck('id')->toArray());

        return $this;
    }

    public function getCitationAttribute()
    {
        return $this->citations->first();
    }

    public function setCitationAttribute($citations)
    {
        if (! $citations) {
            return;
        }

        if (! $this->exists) {
            $this->queuedCitations = [$citations];

            return;
        }

        $this->attachCitations($citations);
    }
}
