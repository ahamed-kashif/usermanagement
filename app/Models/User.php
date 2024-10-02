<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    public function uris()
    {
        return $this->hasMany(ResponseViewUrl::class,'user_id','id');
    }

    public function hasRole($role)
    {
        return $this->role && $this->role === $role;
    }
    protected static function boot()
    {
        parent::boot();

        // Automatically create a URI when a new user is created
        static::created(function ($user) {
            foreach(Form::all() as $form){
                $encodedUri = base64_encode($user->email . '|' . $form->id);
                $urlSafeUri = str_replace(['+', '/', '='], ['-', '_', ''], $encodedUri); // Replace characters for URL safety

                // Create the URI
                $user->uris()->create([
                    'uri' => $urlSafeUri, // Use the URL-safe version of the base64-encoded URI
                    'form_id' => $form->id,
                ]);
            }
        });
    }
}
