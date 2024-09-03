<?php

namespace App\Livewire\Common;

use App\Models\Post;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class LikeButton extends Component {
	#[Reactive ]
	public Post $post;

	public function mount( Post $post ) {
		$this->post = $post;
	}

	public function render() {
		return view( 'livewire.common.like-button' );
	}

	public function toggleLike() {
		if ( auth()->guest() ) {
			$this->redirectRoute( 'login', navigate: true );
			return;
		}
		$user = auth()->user();
		$hasLiked = $user->likes()->where( 'posts.id', $this->post->id )->exists();
		if ( $hasLiked ) {
			$user->likes()->detach( $this->post->id );
			return;
		}
		$user->likes()->attach( $this->post->id );
	}
	public function isLiked() {
		if ( auth()->guest() ) {
			return false;
		}
		$user = auth()->user();
		return $hasLiked = $user->likes()->where( 'posts.id', $this->post->id )->exists();

	}
}
