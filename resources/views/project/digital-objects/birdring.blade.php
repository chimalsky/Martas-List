@extends ('layouts.project-digital-objects')

@push('scripts')
	<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/7.3.0/d3.min.js"></script>
	<script src="{{ mix('js/project/birdring.js') }}" defer="true"></script>
@endpush

@section('header-info')
<x-project.digital-object-notes title="Birdring">
    <x-slot name="content">
        @php
            $content = optional(App\ResourceMeta::find(46377))->value ?? 'No content yet';
        @endphp

        {!! $content !!}
    </x-slot>
</x-project.digital-object-notes>
@endsection

@section('content')
<div class="mt-10">
    <iframe style="border: 1px solid rgba(0, 0, 0, 0.1); margin: 0 auto;" width="92%" height="720" src="https://www.figma.com/embed?embed_host=share&url=https%3A%2F%2Fwww.figma.com%2Ffile%2FtzwBR4UCuQ0dNjtjgL2U0L%2FSound-Ring-%257C-Prototype-SP23%3Ftype%3Ddesign%26node-id%3D0%253A1%26t%3D6fIDr0vUH79fjL68-1" allowfullscreen></iframe>
</div>

<main id="birdring-wrapper" 
    class="max-w-5xl mx-auto text-gray-700 text-lg page-content" 
    style="margin-top: 0;" 
    data-style="red">
</main>
@endsection