<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PostController extends Controller {
	public function index() {
		return view( 'posts.index', [
			'categories' => Category::
				whereHas( 'posts', function (Builder $query) {
					// dd( $query->toRawSql() );
					// return $query;
					return $query->published();
				} )
				->take( 10 )->get()
		] );
	}
}
