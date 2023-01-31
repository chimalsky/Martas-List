<a href="@route('project.about')" class="font-semibold block px-4 py-2 leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
    About
</a>
<div class="mr-4 ml-10 italic text-gray-700 mb-1">
    <a href="@route('project.about-dedication')" class="block">→ Dedication</a>
    <a href="@route('project.about-colophon')" class="block">→ Colophon</a>
    <a href="@route('project.about-overview')" class="block">→ Project Overview: Coordinates</a>
    <a href="@route('project.about-navigation')" class="block">→ Navigation</a>
    <a href="@route('project.about-sources')" class="block">→ Sources + Resources</a>
</div>
<a href="@route('project.poems.index')" class="font-bold block px-4 py-2 leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 flex items-center">
    <img src="{{ asset('img/poem-archive-icon.png') }}" class="w-10 object-cover inline-block mr-1" /> 
    <span>Poem Archive</span>
</a>
<a href="@route('project.birds.index')" class="font-bold block px-4 py-2 leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900 flex items-center">
    <img src="{{ asset('img/bird-archive-icon.png') }}" class="w-10 object-cover inline-block mr-1" /> 
    Bird Archive
</a>
<a href="@route('project.digital-objects.birdring')" class="font-bold block px-4 py-2 leading-5 text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
    <img src="{{ asset('img/do-3.png') }}" class="w-8 rounded-full object-cover inline-block mr-2" /> 
    <span style='margin-left: 2px'>Bird-Ring</span>
</a>
<a href="" style="background-color: #F7F5E7" class="block px-4 py-2 leading-5 text-gray-700 hover:underline focus:outline-none focus:bg-gray-100 focus:text-gray-900">
    Visitors' Field Notes
</a>