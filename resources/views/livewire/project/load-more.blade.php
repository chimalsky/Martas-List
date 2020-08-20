<div>
    @if ($poems->hasMorePages())
        <div class="justify-center flex">
            <svg class="animate-spin -ml-1 mr-3 h-10 w-10 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>

        <button wire:click="loadMore" id="js-load-more" class="invisible">
            Load More {{ $this->poemsRemaining }} Manuscripts Remaining
        </button>
    @endif 


    @if ($poems->hasMorePages())
        <script>
            window.addEventListener('scroll', function(e) {
                let loadMoreButton = document.querySelector('#js-load-more')

                if (!loadMoreButton) {
                    return
                }

                if (loadMoreButton.getAttribute('loading')) {
                    return
                }

                let bounding = loadMoreButton.getBoundingClientRect()

                if (
                    bounding.top >= 0 &&
                    bounding.left >= 0 &&
                    bounding.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
                    bounding.right <= (window.innerWidth || document.documentElement.clientWidth)
                ) {
                    loadMoreButton.setAttribute('loading', true)

                    setTimeout(function() {
                        loadMoreButton.click()
                    }, 600)
                }
            })
        </script>
    @endif
</div>
