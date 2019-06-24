@extends('layouts.web')

@section('content')

<header class="my-8 flex justify-between">
    <a class="btn btn-gray align-top" href="{{ route('encodings.index') }}">
        Return to my list of Encodings 
    </a>

    {{ html()->form('DELETE', route('encodings.destroy', $encoding))->open() }}
        <button class="btn btn-red align-top">
            Delete
        </button>
    {{ html()->form()->close() }}
</header>


<form action="{{ route('encoding.metas.store', $encoding) }}" method="post"
    class="mt-8 bg-gray-300 p-4 mb-4">
    @csrf

    <h1 class="m-2 font-semibold">
        Add new tag 
    </h1>

    @include('encodings.meta.form')

    <button class="btn btn-blue">
        Add this tag to encoding {{ $encoding->encoder_assigned_id }}
    </button>
</form>


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
        @if ($encoding->meta->count())
            Existing Tags 
        @else 
            Add Some Tags to that Encoding!
        @endif
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


@endsection