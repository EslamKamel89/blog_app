@props( [ 'active', 'navigate' => true ] )

@php
	$classes = ( $active ?? false )
		? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 font-medium leading-5  focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out  hover:text-yellow-900 text-sm text-yellow-500'
		: 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent  font-medium leading-5   hover:border-gray-300 focus:outline-none  focus:border-gray-300 transition duration-150 ease-in-out  hover:text-gray-900 text-sm text-gray-500';
@endphp

<a {{ $navigate ? 'wire:navigate' : '' }} {{ $attributes->merge( [ 'class' => $classes ] ) }}>
    {{ $slot }}
</a>
