<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser {
	use HasApiTokens;
	use HasFactory;
	use HasProfilePhoto;
	use Notifiable;
	use TwoFactorAuthenticatable;

	const ROLE_ADMIN = 'ADMIN';
	const ROLE_EDITOR = 'EDITOR';
	const ROLE_USER = 'USER';
	const ROLE_DEFAULT = self::ROLE_USER;

	const ROLES = [
		self::ROLE_ADMIN => 'Admin',
		self::ROLE_EDITOR => 'Editor',
		self::ROLE_USER => 'User',
	];


	protected $fillable = [
		'name',
		'email',
		'password',
		'role',
	];

	// The attributes that should be hidden for serialization.
	protected $hidden = [
		'password',
		'remember_token',
		'two_factor_recovery_codes',
		'two_factor_secret',
	];


	// The accessors to append to the model's array form.
	protected $appends = [
		'profile_photo_url',
	];


	// Get the attributes that should be cast.
	protected function casts(): array {
		return [
			'email_verified_at' => 'datetime',
			'password' => 'hashed',
		];
	}



	//! Reloationships
	public function likes(): BelongsToMany {
		return $this->belongsToMany( Post::class, 'post_like' )
			->withTimestamps();
	}
	public function comments(): HasMany {
		return $this->hasMany( Comment::class);
	}

	//! filament panel admin user
	public function canAccessPanel( Panel $panel ): bool {
		// return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
		return $this->isAdmin() || $this->isEditor();
	}

	public function isAdmin(): bool {
		return $this->role == self::ROLE_ADMIN;
	}
	public function isNotAdmin(): bool {
		return $this->role != self::ROLE_ADMIN;
	}
	public function isEditor(): bool {
		return $this->role == self::ROLE_EDITOR;
	}
	public function isUser(): bool {
		return $this->role == self::ROLE_USER;
	}
}
/**
 *  -------- roles :
 * Admin >> do every thing
 * Editor >> create posts and categoires
 * User >> like and comment
 */
