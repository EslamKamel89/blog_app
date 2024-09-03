<div>
    <a href="#">
        <div class="h-[200px] w-[300px]">
            <img class="min-w-full min-h-full rounded-xl bg-contain" src="{{ $post->getThumbnailImage() }}">
        </div>
    </a>
    <div class="mt-7">
        <div class="flex items-center mb-2">
            <div class="flex flex-wrap gap-1 max-w-sm">

                @foreach ( $post->categories as $category )
					<x-common.category-badge :category="$category" />
				@endforeach
            </div>
            <p class="text-gray-500 text-sm">{{$post->published_at}}</p>
        </div>
        <a href="#" class="text-xl font-bold text-gray-900">{{ $post->title }}</a>
    </div>
</div>
