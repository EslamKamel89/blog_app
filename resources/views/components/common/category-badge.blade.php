<div class="flex items-center space-x-1">
    <x-common.badge href="{{route( 'posts.index', [ 'category' => $category->title ] )}}" wire:navigate
        :textColor="$category->text_color" :bgColor="$category->bg_color">
        {{ $category->title }}
    </x-common.badge>
</div>
