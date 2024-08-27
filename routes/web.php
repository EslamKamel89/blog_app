<?php

use App\Http\Controllers\HomeController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get( '/', HomeController::class);
Route::get( '/test', function () {
	$post = Post::find( 1 );
	dump( $post->categories );
} );

Route::middleware( [
	'auth:sanctum',
	config( 'jetstream.auth_session' ),
	'verified',
] )->group( function () {
	Route::get( '/dashboard', function () {
		return view( 'dashboard' );
	} )->name( 'dashboard' );
} );
