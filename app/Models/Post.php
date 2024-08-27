<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
}
