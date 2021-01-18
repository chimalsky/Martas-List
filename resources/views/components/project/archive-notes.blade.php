<section class="hidden lg:flex justify-end -mt-8" x-data="{notesOpen: false}">
    <button x-show="!notesOpen" @click="notesOpen = true" 
        class="text-lg border-t border-gray-700 pl-20">
        + Archive Notes
    </button>

    <aside x-show="notesOpen" 
        x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-0 overflow-hidden"  data-style="yellow" >
        <div class="absolute inset-0 overflow-hidden">
            <section class="absolute inset-y-0 right-0 pl-10 max-w-full flex">
                <!--
                    Slide-over panel, show/hide based on slide-over state.

                    Entering: "transform transition ease-in-out duration-500 sm:duration-700"
                    From: "translate-x-full"
                    To: "translate-x-0"
                    Leaving: "transform transition ease-in-out duration-500 sm:duration-700"
                    From: "translate-x-0"
                    To: "translate-x-full"
                -->
                <div @click.away="notesOpen = false" class="w-screen max-w-md">
                    <div class="h-full flex flex-col space-y-6 py-6 bg-white shadow-xl overflow-y-scroll">
                        <header class="px-4 sm:px-6 relative">
                            <h1 class="text-center">
                                {{ $title ?? null }} Archive Notes
                            </h1>

                            <button @click="notesOpen = false" aria-label="Close panel" class="absolute top-0 right-0 mr-4 -mt-4 text-base">
                                X
                            </button>
                        </header>

                        <main class="archive-notes relative flex-1 text-left">
                            <!-- Replace with your content -->
                            <div data-content class="inset-0 px-2">
                                <div class="h-full pl-6">
                                    {{ $slot }}

                                    @php 
                                        $content = optional(App\ResourceMeta::find($contentId))->value ?? 'No content yet';
                                    @endphp
                                    <div data-main class="pr-8">
                                        {!! $content !!}
                                    </div>
                                </div>
                            </div>
                            <!-- /End replace -->
                        </main>

                        <footer class="border-t border-orange-300 pb-4">
                            <button @click="notesOpen = false" aria-label="Close panel" class="text-black text-xl underline hover:text-gray-900 transition ease-in-out duration-150 inline-block align-middle">
                                Close Notes
                            </button>
                        </footer>
                    </div>
                </div>
            </section>
        </div>
    </aside>
</section>