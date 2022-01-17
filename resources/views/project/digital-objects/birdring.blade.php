@extends ('layouts.project-shifted')

@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.3.0/d3.min.js"></script>
	<script src="{{ mix('js/project/birdring.js') }}" defer="true"></script>
@endpush

@section('content')
<main class="max-w-2xl mx-auto text-gray-700 text-lg page-content" style="margin-top: -48px;" data-style="red">
	<div class="max-w-sm mx-auto" id="birdring"></div>
	<h1 id="selectedDatum" style="z-index: 9999; background: transparent;"></h1>
	<div id="birdhorizon">
		<canvas id='birdhorizoncanvas'></canvas>
	</div>
</main>
@endsection