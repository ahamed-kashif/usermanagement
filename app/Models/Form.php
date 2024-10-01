<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Form extends Model
{
    use HasFactory;
    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    public function responses(){
        return $this->hasMany(FormResponse::class, 'form_id', 'id');
    }

    public function uris()
    {
        return $this->hasMany(ResponseViewUrl::class, 'form_id', 'id');
    }
    public static function boot(){
        parent::boot();
        static::creating(function($form){
            $form->code = Str::uuid();
        });
    }
}
