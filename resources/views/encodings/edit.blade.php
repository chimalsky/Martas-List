@extends('layouts.web')

@section('content')

<header class="my-8">
    <a class="btn btn-gray" href="{{ route('encodings.index') }}">
        Return to my list of Encodings 
    </a>
</header>

<section class="flex flex-wrap mb-8 p-4 border border-1 border-gray-600">
    {{ html()->modelForm($encoding, 'PUT', route('encodings.update', $encoding))->open() }}
        @include('encodings.form')

        <footer class="py-4 justify-end">
            <button class="btn btn-blue">
                Save Changes 
            </button>
        </footer>
    {{ html()->closeModelForm() }}
</section>

<section class="flex flex-wrap">
    <h1 class="m-2 text-2xl w-full">
        Existing Tags 
    </h1>

    @foreach ($encoding->meta as $meta)
        <article class="w-full border border-1 border-gray-400 mb-4 py-4">
            {{ html()->modelForm($meta, 'PUT', route('encoding.metas.update', [
                'encoding' => $encoding, 
                'meta' => $meta
            ] ))->open() }}
                
                @include('encodings.meta.item', ['meta' => $meta])

            {{ html()->closeModelForm() }}

            {{ html()->modelForm($meta, 'DELETE', route('encoding.metas.destroy', [
                'encoding' => $encoding, 
                'meta' => $meta
            ] ))->open() }}
                <div class="flex justify-end mr-4 mt-4">
                    <button class="btn btn-red">
                        Delete
                    </button>
                </div>
            {{ html()->closeModelForm() }}
        </article>
    @endforeach
</section>

<form action="{{ route('encoding.metas.store', $encoding) }}" method="post"
    class="mt-8 bg-gray-300 p-4">
    @csrf

    <h1 class="m-2 font-semibold">
        Add new tag 
    </h1>

    @include('encodings.meta.form')

    <button class="btn btn-blue">
        Add this tag to encoding {{ $encoding->encoder_assigned_id }}
    </button>
</form>

@endsection