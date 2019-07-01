@extends ('layouts.web')

@section ('content')

<section class="flex flex-wrap mb-8">
    <form action="{{ route('resource-types.store') }}" method="post">
        @csrf

        @include('resource-types.form')

        <footer class="py-4">
            <button class="btn btn-blue">
                Create this Resource Type 
            </button>
        </footer>
    </form>
</section>

@endsection