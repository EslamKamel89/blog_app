<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller {
	public function index() {
		$publishedCategories = Cache::remember(
			'pulishedCategories',
			Carbon::now()->addHours( 6 ),
			function () {
				return Category::
					whereHas( 'posts', function (Builder $query) {
						return $query->published();
					} )
					->take( 10 )->get();
			} );
		return view( 'posts.index', [
			'categories' => $publishedCategories
		] );
	}
	public function show( Post $post ) {
		return view( 'posts.show', compact( 'post' ) );
	}
}
