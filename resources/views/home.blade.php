@props( [ 'featuredPosts' ] )
<x-app-layout>
    <x-slot:heroSection>
        <div class="w-full text-center py-32">
            <h1 class="text-2xl md:text-3xl font-bold text-center lg:text-5xl text-gray-700">
                Welcome to <span class="text-yellow-500">&lt;YELO&gt;</span> <span class="text-gray-900"> News</span>
            </h1>
            <p class="text-gray-500 text-lg mt-1">Best Blog in the universe</p>
            <a class="px-3 py-2 text-lg text-white bg-gray-800 rounded mt-5 inline-block"
                href="http://127.0.0.1:8000/blog">Start
                Reading</a>
        </div>
    </x-slot:heroSection>

    <!-- Main Container -->
    <div class="mb-10 min-w-full">
        <!-- Featured Posts -->
        <div>
            <h2 class="mt-16 mb-5 text-3xl text-yellow-500 font-bold">Featured Posts</h2>
            <!-- Featured Posts Grid -->
            <div class="w-full">
                <div class="grid grid-cols-3 gap-10 w-full">
                    @foreach ( $featuredPosts as $post )
						<div class="md:col-span-1 col-span-3">
							<x-posts.post-card :$post />
						</div>
					@endforeach
                </div>
            </div>
            <!-- END Featured Posts Grid -->
            <a class="mt-10 block text-center text-lg text-yellow-500 font-semibold" href="http://127.0.0.1:8000/blog"
                wire:navigate>More
                Posts</a>
            <hr>
        </div>
        <!-- END Featured Posts -->
        <!-- Latest Posts -->
        <div>
            <h2 class="mt-16 mb-5 text-3xl text-yellow-500 font-bold">Latest Posts</h2>
            <!-- Latest Posts Grid -->
            <div class="w-full">
                <div class="grid grid-cols-3 gap-10 w-full">
                    @foreach ( $latestPosts as $post )
						<div class="md:col-span-1 col-span-3">
							<x-posts.post-card :$post />
						</div>
					@endforeach

                </div>
            </div>
            <!-- END Latest Posts Grid -->
            <a class="mt-10 block text-center text-lg text-yellow-500 font-semibold" href="http://127.0.0.1:8000/blog"
                wire:navigate>More
                Posts</a>
        </div>
        <!-- END Latest Posts -->
    </div>
    <!-- END Main Container -->
</x-app-layout>
