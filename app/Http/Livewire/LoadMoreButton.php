<?php

namespace App\Http\Livewire;

use App\Resource as Poem;
use Livewire\Component;

class LoadMoreButton extends Component
{
    protected $poemIds;
    protected $poems;

    public $page;
    public $perPage;
    public $loadMore;

    public function mount($page = 1, $perPage = 1, $poemIds)
    {
        $this->poemIds = $poemIds;
        $this->page = $page + 1; //increment the page
        $this->perPage = $perPage;
        $this->loadMore = false; //show the button

    }

    public function loadMore()
    {
        $this->loadMore = true;
    }

    public function render()
    {
        if ($this->loadMore) {
            $poemsPaginated = Poem::whereIn('id', $$this->poemIds)->paginate($this->perPage, ['*'], null, $this->page);

            //$poems = Poem::whereIn('id', paginate($this->perPage, ['*'], null, $this->page);

            return view('livewire.load-more', compact('poemsPaginated'));
        } else {
            return view('livewire.load-more-button');
        }
    }
}
