<div id="posts" class=" px-3 lg:px-7 py-6" x-data="{}">

    <div class="flex justify-between items-center border-b border-gray-100">
        <div>
            @if($search || $category)
            <button class="text-2xl font-bold mr-2"
            wire:click="clearSearch()">
                x
            </button>
            @endif
            @if ($category )
                <x-common.badge
                    href="{{route( 'posts.index', [ 'category' => $category ] )}}" wire:navigate>
                    {{$category}}
                </x-common.badge>
                @endif
            @if ($search)
                <span> containing: <span class="font-bold ml-2">{{$search}}</span> </span>
            @endif
        </div>
        <div class="flex items-center space-x-4 font-light ">
            <x-checkbox wire:model.live="popular" class="text-yellow-600 shadow-sm focus:ring-yellow-500" />
            <span class="text-gray-500 py-4">Popular</span>
            <div class="h-5 border-l-2 border-gray-500"></div>
            <button class="text-gray-500 py-4 " wire:key="desc" wire:click="setSort('desc'); console.log('desc')"
                :class="{'border-b border-gray-700' : $wire.sort=='desc'}">Latest</button>
            <button class="text-gray-900 py-4" wire:key="asc" wire:click="setSort('asc')"
                :class="{'border-b border-gray-700' : $wire.sort !='desc'};console.log('asc')">Oldest</button>
        </div>
    </div>
    <div class="py-4">
        @foreach ( $this->posts as $post )
			<x-posts.post-item :$post />
		@endforeach
    </div>
    <div class="my-3">
        {{ $this->posts->onEachSide( 1 )->links() }}
    </div>
</div>
