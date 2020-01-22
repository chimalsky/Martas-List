@extends ('layouts.web')

@section ('content')

    @foreach ($projects as $project)
        <a href="">
            {{ $project->name }}

            {{ $project->owner->name }}

            {{ $project->collaborators }}
        </a>
    @endforeach
@endsection