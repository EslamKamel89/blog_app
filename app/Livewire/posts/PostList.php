<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Illuminate\Database\Eloquent\Builder;

class PostList extends Component {
	use WithPagination;
	#[Url ]
	public $sort = 'desc';
	#[Url ]
	public $search = '';
	#[Url ]
	public $category = '';
	#[Url ]
	public $popular = false;

	public function setSort( $sort ) {
		// dump( $sort );
		$this->sort = $sort;
		$this->resetPage();
	}

	#[Computed ]
	public function posts() {
		return Post::with( [ 'author', 'comments', 'categories' ] )
			->where( 'title', 'like', '%' . $this->search . '%' )
			->when(
				$this->popular,
				fn( Builder $query ) => $query->popular(),
			)->withCategroy( category: $this->category )
			->orderBy(
				'published_at',
				$this->sort === 'desc' ? 'desc' : 'asc'
			)->paginate( 5 );
	}

	#[On('search') ]
	public function updateSearch( $search ) {
		$this->search = $search;
	}

	public function render() {
		return view( 'livewire.posts.post-list' );
	}
	function clearSearch() {
		$this->search = '';
		$this->category = '';
	}
}
