<?php

namespace App\Http\Livewire;

use App\ResourceType;
use Livewire\Component;

class LoadMore extends Component
{
    public $resourceType;

    public $page;

    public $perPage;

    public function mount($resourceType, $page, $perPage)
    {
        $this->resourceType = ResourceType::find($resourceType);
        $this->page = $page ? $page : 1;
        $this->perPage = $perPage ? $perPage : 1;
    }

    public function render()
    {
        $rows = $this->resourceType->resources()
            ->paginate($this->perPage, ['*'], null, $this->page);

        return view('livewire.load-more', [
            'rows' => $rows,
            'page' => $this->page,
        ]);
    }
}
