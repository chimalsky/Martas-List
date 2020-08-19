<div>
    <button wire:click="loadMore" id="js-load-more">
        Load More {{ $this->poemsRemaining }} Manuscripts Remaining
    </button>

    @if ($poems->hasMorePages())
        <h1 class="text-4xl text-red-600">
            HEY!!
        </h1>
    @endif 


    @if ($poems->hasMorePages())
        <script>
            window.addEventListener('scroll', function(e) {
                let loadMoreButton = document.querySelector('#js-load-more')
                let bounding = loadMoreButton.getBoundingClientRect()

                if (
                    bounding.top >= 0 &&
                    bounding.left >= 0 &&
                    bounding.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    bounding.right <= (window.innerWidth || document.documentElement.clientWidth)
                ) {
                    loadMoreButton.click()
                }
            })
        </script>
    @endif
</div>
