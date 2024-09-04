<?php

namespace App\Livewire\Posts;

use App\Models\Comment;
use App\Models\Post;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\WithPagination;

class PostComments extends Component {
	use WithPagination;
	public Post $post;

	#[Validate('required|min:2|max:200') ]
	public string $comment = '';

	#[Computed ]
	public function comments() {
		return $this->post->comments()->latest()->paginate( 2 );
	}


	public function mount( Post $post ) {
		$this->post = $post;
	}

	public function render() {
		return view( 'livewire.posts.post-comments' );
	}


	public function postComment() {
		if ( auth()->guest() ) {
			return;
		}
		$this->validateOnly( 'comment' );
		Comment::create( [ 
			'user_id' => auth()->id(),
			'post_id' => $this->post->id,
			'comment' => $this->comment,
		] );
		$this->comment = '';
	}
}
