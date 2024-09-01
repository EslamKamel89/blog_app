<div>
    <h3 class="text-lg font-semibold text-gray-900 mb-2 ">Recommended Topics</h3>
    <div class="topics flex flex-wrap justify-start gap-2">
        @foreach ( $categories as $category )
			<x-common.badge :textColor="$category->text_color" :bgColor="$category->bg_color"
				href="{{route( 'posts.index', [ 'category' => $category->title ] )}}" wire:navigate>
				{{$category->title}}
			</x-common.badge>
		@endforeach
    </div>
</div>
