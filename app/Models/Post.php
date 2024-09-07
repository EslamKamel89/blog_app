<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model {
	use HasFactory;
	use SoftDeletes;
	protected $fillable = [ 
		'user_id',
		'image',
		'title',
		'slug',
		'body',
		'published_at',
		'featured',
	];

	//! Relations
	public function categories(): BelongsToMany {
		return $this->belongsToMany( Category::class);
	}
	public function author() {
		return $this->belongsTo( User::class, 'user_id' );
	}
	public function likes(): BelongsToMany {
		return $this->belongsToMany( User::class, 'post_like' );
	}
	public function comments(): HasMany {
		return $this->hasMany( Comment::class);
	}

	//! Scopes
	public function scopePublished( Builder $query ) {
		return $query->where( 'published_at', '<=', Carbon::now() );
	}
	public function scopeFeatured( Builder $query ) {
		return $query->where( 'featured', true );
	}
	public function scopeWithCategroy( Builder $query, string $category ) {
		$query->whereHas( 'categories', function (Builder $query) use ($category) {
			$query->where( 'title', 'like', '%' . $category . '%' );
		} );
	}
	public function scopePopular( Builder $query ) {
		return $query->withCount( 'likes' )->orderBy( 'likes_count', 'desc' );
	}
	public function scopeSearch( Builder $query, $search = '' ) {
		return $query->where( 'title', 'like', '%' . $search . '%' );
	}


	//! Casts
	protected function casts(): array {
		return [ 
			'published_at' => 'datetime',
		];
	}

	//! Helper methods
	public function timeToRead() {
		return ceil( ( Str::wordCount( $this->body ) / 250 ) );
	}
	public function getExcerpt() {
		return Str::limit( strip_tags( $this->body ), 100 );
	}

	public function getThumbnailImage() {
		$isUrl = Str::startsWith( $this->image, 'http' );
		return $isUrl ? $this->image : Storage::disk( 'public' )->url( $this->image );
	}


}
