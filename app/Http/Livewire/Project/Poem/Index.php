<?php

namespace App\Http\Livewire\Project\Poem;

use App\Project\Poem;
use App\Project\Transcription;
use App\ResourceAttribute;
use App\ResourceCategory;
use App\ResourceType;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Index extends Component
{
    public $poemDefinition;

    public $poems;

    public $poemIds;

    public $perPage = 15;

    public $titleMeta = 84;

    public $filterQuery;

    public $filterOrderable;

    public $filterOrderableDirection = 'asc';

    public $filterCategoryBirds;

    public $filterFilterables;

    public $orderablesAndPoems;

    public $activeOrderableValue;

    public $readyToLoad = false;

    protected $listeners = [
        'poem.filter:query-updated' => 'updatePoemsByQuery',
        'poem.filter:orderable-updated' => 'updatePoemsByOrderable',
        'poem.filter:bird-updated' => 'updatePoemsByBirds',
        'poem.filter:filterable-updated' => 'updatePoemsByFilterables',
        'poem.filter:resetted' => 'filterResetted',
    ];

    public function mount()
    {
        $this->poemDefinition = ResourceType::find(Poem::resource_type_id);
        $this->filterOrderable = $this->poemDefinition->attributes->firstWhere('id', 84);
    }

    public function loadResources()
    {
        $this->readyToLoad = true;
    }

    public function resetPoems()
    {
        $this->poems = $this->potentialPoems->take($this->perPage)->get();
    }

    public function getPotentialPoemsProperty()
    {
        return Poem::select('id')->with('transcription');
    }

    public function getPoemsFilteredProperty()
    {
        $poems = Poem::with('transcription');

        if ($this->filterCategoryBirds && $this->filterCategoryBirds->count()) {
            $connectedPoemsIds = $this->filterCategoryBirds->pluck('connections')->flatten()->pluck('id');
            $poems = $poems->whereIn('id', $connectedPoemsIds);
        }

        if ($this->filterFilterables && $this->filterFilterables->count()) {
            foreach ($this->filterFilterables as $filterable) {
                $poems = $poems->whereHas('meta', function ($query) use ($filterable) {
                    $query = $query->where('resource_attribute_id', $filterable['id']);

                    if ($filterable['activeValues']) {
                        $query = $query->whereIn('value', $filterable['activeValues']);
                    }
                });
            }
        }

        if ($this->filterQuery) {
            $query = $this->filterQuery;
            $transcriptions = Transcription::search($query)->get();

            $poems = $poems->whereIn('id', $transcriptions->pluck('resource_id'));

            /*
            $poems = $poems->whereHas('transcription', function($transcriptionQuery) use ($query) {
                $transcriptionQuery->search($query);
            })->with('category.resources'); */
        }

        $poems = $poems->withHeadlineValue($this->titleMeta)
            ->withQueryableMetaValue($this->filterOrderable->id)
            ->orderBy('queryable_meta_value', $this->filterOrderableDirection);

        return $poems;
    }

    public function getPoemsPaginatedProperty()
    {
        return $this->poems->paginate($this->perPage);
    }

    public function getPoemIdsProperty()
    {
        return $this->poems->pluck('id');
    }

    public function updatePoemsByQuery(string $query)
    {
        $validator = Validator::make([
            'query' => $query,
        ], [
            'query' => ['required', 'string', 'min:2'],
        ]);

        if ($validator->fails()) {
            $this->filterQuery = null;

            return;
        }

        $this->filterQuery = $query;
    }

    public function updatePoemsByOrderable($orderableId, $orderableDirection)
    {
        $this->filterOrderable = ResourceAttribute::find($orderableId);
        $this->filterOrderableDirection = $orderableDirection;
    }

    public function updatePoemsByBirds(array $activeBirds)
    {
        $this->filterCategoryBirds = ResourceCategory::whereIn('id', $activeBirds)->get();
    }

    public function updatePoemsByFilterables(array $filterables)
    {
        $this->filterFilterables = collect($filterables);
    }

    public function resetAllFilters()
    {
        $this->reset('filterCategoryBirds');
        $this->reset('filterQuery');
        $this->reset('filterFilterables');

        $this->emit('poem.index:resetted');
    }

    public function filterResetted()
    {
        $this->reset('filterCategoryBirds');
        $this->reset('filterQuery');
        $this->reset('filterFilterables');
    }

    public function render()
    {
        if ($this->readyToLoad) {
            $this->poems = $this->poemsFiltered->get();
        } else {
            $this->poems = [];
        }

        $this->poemIds = $this->poems
            ? $this->poems->pluck('id')
            : [];

        /*$this->orderablesAndPoems = collect($this->poems)
            ->take($this->perPage)
            ->groupBy('queryable_meta_value')
            ->filter(function($group) {
                return $group->count();
            }); */

        $this->emit('poem.index:rendering', $this->poemIds);

        return view('livewire.project.poem.index');
    }
}
