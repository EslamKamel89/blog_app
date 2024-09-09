<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller {
	public function __invoke( Request $request ) {
		$featuredPosts = Cache::remember(
			'featuredPosts',
			Carbon::now()->addHours( 5 ),
			function () {
				return Post::featured()
					->published()
					->with( 'categories' )
					->latest( 'published_at' )
					->get();
			}
		);
		$latestPosts = Cache::remember( 'latestPosts', Carbon::now()->addHours( 5 ), function () {
			return Post::latest( 'published_at' )
				->published()
				->with( 'categories' )
				->limit( 9 )
				->get();
		} );


		return view( 'home', [
			'featuredPosts' => $featuredPosts,
			'latestPosts' => $latestPosts,
		] );
	}
}
