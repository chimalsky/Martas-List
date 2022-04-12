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
    <div class="mx-auto max-w-sm">
        <iframe width="100%" height="120" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/1229912158&color=%23ff5500&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"></iframe><div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="https://soundcloud.com/danielle-richards-973620677" title="Danielle Richards" target="_blank" style="color: #cccccc; text-decoration: none;">Danielle Richards</a> · <a href="https://soundcloud.com/danielle-richards-973620677/july" title="July" target="_blank" style="color: #cccccc; text-decoration: none;">July</a></div>
    </div>
    <section class="bg-yellow-300 p-24 mt-20">
        Notes
    </section>
</main>
@endsection