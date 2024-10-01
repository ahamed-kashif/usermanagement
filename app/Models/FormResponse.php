<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class FormResponse extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $guarded = [
        'id', 'creates_at', 'updates_at'
    ];
    public function originUrl()
    {
        return $this->belongsTo(ResponseViewUrl::class, 'origin_uri','uri');
    }
}
