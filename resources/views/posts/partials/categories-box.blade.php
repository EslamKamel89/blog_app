<div>
    <h3 class="text-lg font-semibold text-gray-900 mb-2 ">Recommended Topics</h3>
    <div class="topics flex flex-wrap justify-start gap-2">
        @foreach ( $categories as $category )
			<x-common.category-badge :category="$category" />
		@endforeach
    </div>
</div>
