<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller {
	public function __invoke( Request $request ) {
		return view( 'home', [
			'featuredPosts' => Post::featured()
				->published()
				->latest( 'published_at' )
				->get(),
			'latestPosts' => Post::latest( 'published_at' )
				->published()
				->limit( 9 )
				->get(),
		] );
	}
}
