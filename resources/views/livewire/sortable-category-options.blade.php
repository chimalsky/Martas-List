<div>
    <div wire:sortable="updateCategoryOrder" wire:sortable-group="updateOptionOrder" style="display: flex">
        @foreach ($categories as $category)
            <div wire:key="category-{{ $category->id }}" wire:sortable.item="{{ $category->id }}">
                <div style="display: flex">
                    <h4 wire:sortable.handle>{{ $category->name }}</h4>
                </div>

                <ul wire:sortable-group.item-group="{{ $category->id }}">
                    @foreach ($category->options as $option)
                        <li wire:key="option-{{ $option->id }}" wire:sortable-group.item="{{ $option->id }}">
                            {{ $option->value }}
                        </li>
                    @endforeach
                </ul>



                <form wire:submit.prevent="addOption({{ $category->id }}, $event.target.value.value)">
                    <input type="text" name="value" class="form-input">

                    <button>Add Option</button>
                </form>
            </div>
        @endforeach
    </div>


    <form wire:submit.prevent="addCategory">
        <input type="text" class="form-input" wire:model="newCategory">
        @error('newCategory')<span class="error">{{ $message }}</span> @enderror

        <button class="btn btn-blue">Add Category</button>
    </form>
</div>
