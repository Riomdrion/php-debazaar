<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'taal',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Advertenties van gebruiker
    public function advertenties() {
        return $this->hasMany(Advertentie::class);
    }

    public function verhuurAdvertenties() {
        return $this->hasMany(VerhuurAdvertentie::class);
    }

    public function bedrijf() {
        return $this->hasOne(Bedrijf::class);
    }

    public function favorites() {
        return $this->hasMany(Favorite::class);
    }

    public function bid() {
        return $this->hasMany(Bid::class);
    }

    public function AgendaItem()
    {
        return $this->hasMany(AgendaItem::class);
    }

    public function review() {
        return $this->hasMany(Review::class);
    }

    public function favorieten()
    {
        return $this->hasMany(Favoriet::class);
    }
}
