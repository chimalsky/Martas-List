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
<main id="birdring-wrapper" 
    class="max-w-5xl mx-auto text-gray-700 text-lg page-content" 
    style="margin-top: -80px;" 
    data-style="red">
</main>
@endsection