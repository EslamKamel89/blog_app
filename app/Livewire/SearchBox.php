<?php

namespace App\Livewire;

use Livewire\Component;

class SearchBox extends Component {

	public $search = '';
	public function render() {
		return view( 'livewire.search-box' );
	}
	// public function updatedSearch() {
	// 	$this->dispatch( 'search', $this->search );
	// }
	public function updateSearch() {
		$this->dispatch( 'search', $this->search );
	}
}
