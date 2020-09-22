<div>


@if ($poems->currentPage() <= $poems->lastPage())
<div class="justify-center flex">
    <div class="animate-ping h-12 w-12 text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-50 active:text-gray-800 transition ease-in-out duration-150">
        <img src="{{ asset('img/bird-icon-round.png') }}" />
    </div>
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
            }, 1200)
        }
    })
</script>
@endif

</div>

