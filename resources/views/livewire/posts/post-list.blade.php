<div id="posts" class=" px-3 lg:px-7 py-6" x-data="{}">

    <div class="flex justify-between items-center border-b border-gray-100">
        <div>
            @if($search || $category)
            <button class="text-2xl font-bold mr-2"
wire:click="clearSearch()"
            >x</button>
            @endif
            @if ($category)
                <span>All Posts from  </span>
                <x-common.badge
                    href="{{route( 'posts.index', [ 'category' => $category ] )}}" wire:navigate>
                    {{$category}}
                </x-common.badge>
                @endif
            @if ($search)
                <span> Contains {{$search}}</span>
            @endif
        </div>
        <div class="flex items-center space-x-4 font-light ">
            <button class="text-gray-500 py-4 " wire:click="setSort('desc')"
                :class="{'border-b border-gray-700' : $wire.sort=='desc'}">Latest</button>
            <button class="text-gray-900 py-4" wire:click="setSort('asc')"
                :class="{'border-b border-gray-700' : $wire.sort!='desc'}">Oldest</button>
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
