@extends('layouts.web')

@section('content')

<section class="flex flex-wrap mb-8">
    <form action="{{ route('encodings.store') }}" method="post">
        @csrf

        @include('encodings.form')

        <footer class="py-4">
            <button class="btn btn-blue">
                Create this Encoding 
            </button>
        </footer>
    </form>
</section>

@endsection