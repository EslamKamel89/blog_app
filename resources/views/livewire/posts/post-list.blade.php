<div id="posts" class="px-3 py-6 lg:px-7" x-data="{}">
    <div class="flex items-center justify-between border-b border-gray-100 ">
        <div>
                <button
                    class="mr-2 text-2xl font-bold {{($category || $search)? '' : 'hidden'}}"
                    wire:click="clearSearch()"
                >
                    x
                </button>

                <x-common.badge
                class="{{$category? '' : 'hidden'}}"
                    href="{{route( 'posts.index', [ 'category' => $category ] )}}"
                    wire:navigate
                >
                    {{ $category }}
                </x-common.badge>

                <span class="{{ $search? '' : 'hidden' }}">
                    containing:
                    <span class="ml-2 font-bold">{{ $search }}</span>
                </span>
        </div>
        <div class="flex items-center space-x-4 font-light">
            <x-checkbox
                wire:model.live="popular"
                class="text-yellow-600 shadow-sm focus:ring-yellow-500"
            />
            <span class="py-4 text-gray-500">Popular</span>
            <div class="h-5 border-l-2 border-gray-500"></div>
            <button
                class="py-4 text-gray-500"
                wire:key="desc"
                wire:click="setSort('desc'); "
                :class="{'border-b border-gray-700' : $wire.sort=='desc'}"
            >
                Latest
            </button>
            <button
                class="py-4 text-gray-900"
                wire:key="asc"
                wire:click="setSort('asc')"
                :class="{'border-b border-gray-700' : $wire.sort !='desc'}"
            >
                Oldest
            </button>
        </div>
    </div>
    <div class="py-4">
        @foreach ($this->posts as $post)
        <div wire:key="{{ $post->id }} . ' Post Item Blade Component'">
            <x-posts.post-item :$post  />
        </div>
        @endforeach
    </div>
    <div class="my-3">
        {{ $this->posts->onEachSide(1)->links() }}
    </div>
</div>
