@props( [
	'author',
	'size' => 'sm',
] )
@php
	$imageSize = match ( $size ) {
		'sm' => 'w-7 h-7',
		'md' => 'w-10 h-10',
		'lg' => 'w-13 h-13',
		default => 'w-7 h-7',
	};
	$textSize = match ( $size ) {
		'sm' => 'text-xs',
		'md' => 'text-sm',
		'lg' => '',
		default => 'text-sm',
	}
@endphp
<div class="flex gap-1 items-center mr-2">
    <img class=" {{ $imageSize  }} rounded-full mr-3" src="{{$author->profile_photo_url}}" alt="avatar">
    <span class="mr-1 {{ $textSize }}">{{$author?->name ?? 'Unkown User'}}</span>
</div>
