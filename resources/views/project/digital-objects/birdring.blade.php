@extends ('layouts.project-digital-objects')

@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.3.0/d3.min.js"></script>
	<script src="{{ mix('js/project/birdring.js') }}" defer="true"></script>
@endpush

@section('content')
<style>
    path[data-chrono] {
        font-size: 32px;
    }
</style>
<main class="max-w-5xl mx-auto text-gray-700 text-lg page-content" style="margin-top: -80px;" data-style="red">
	<div class="max-w-sm mx-auto" id="birdring"></div>
	<h1 id="selectedDatum" class="text-lg" style="z-index: 9999; background: transparent;"></h1>
	<div id="birdhorizon">
		<svg id='birdhorizoncanvas'>
        </svg>
	</div>
    <div id="chrono-player" class="flex justify-center">
        <button id="play">
            Play
        </button>
        <button id="pause" style="display: none">
            Pause
        </button>
    </div>
    <section class="bg-yellow-300 p-24 mt-20">
        Notes
    </section>
</main>
@endsection