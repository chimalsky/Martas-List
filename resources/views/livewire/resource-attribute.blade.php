<div>
    <footer class="flex justify-end">
        <a wire:click="delete" 
            wire:loading.class="opacity-50 cursor:not-allowed" 
            wire:loading.attr="disabled"
            class="btn btn-red mt-1 cursor-pointer">
            Delete
        </a>

        <div wire:loading wire:target="delete"
            class="mx-2">
            Deleting 
        </div>
    </footer>
</div>
