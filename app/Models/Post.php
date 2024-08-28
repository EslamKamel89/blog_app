<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Post extends Model {
	use HasFactory;
	protected $fillable = [
		'image',
		'title',
		'slug',
		'body',
		'published_at',
		'featured',
	];
	public function categories(): BelongsToMany {
		return $this->belongsToMany( Category::class);
	}
	public function scopePublished( Builder $query ) {
		return $query->where( 'published_at', '<=', Carbon::now() );
	}
	public function scopeFeatured( Builder $query ) {
		return $query->where( 'featured', true );
	}
	public function author() {
		return $this->belongsTo( User::class, 'user_id' );
	}

	protected function casts(): array {
		return [
			'published_at' => 'datetime',
		];
	}
	public function timeToRead() {
		return ceil( ( Str::wordCount( $this->body ) / 250 ) );
	}
	public function getExcerpt() {
		return Str::limit( strip_tags( $this->body ), 100 );
	}
}
