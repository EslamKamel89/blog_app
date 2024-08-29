<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class PostList extends Component {
	use WithPagination;
	#[Url ]
	public $sort = 'desc';
	#[Url ]
	public $search = '';

	public function setSort( $sort ) {
		$this->sort = $sort;
		$this->resetPage();
	}

	#[Computed ]
	public function posts() {
		return Post::
			where( 'title', 'like', '%' . $this->search . '%' )
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
		return view( 'livewire.post-list' );
	}
}
