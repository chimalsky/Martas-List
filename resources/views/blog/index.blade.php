@extends('layouts.web')

@section('content')

@guest
@else
<header class="flex justify-end">
    <a href="/wink" class="btn btn-hollow" target="_blank"> 
        Write a post
    </a>
</header>
@endguest

<section class="my-8">
    @foreach ($posts as $post)
        <article class='w-full mb-4'>
            <h1 class="font-semibold">
                {{ $post->title }}
            </h1>

            <div>
                {!! $post->body !!}
            </div>

            <footer class="text-right">
                {{ $post->publish_date }} -- {{ $post->author->name }}
            </footer>
        </article>
    @endforeach
</section>

@endsection