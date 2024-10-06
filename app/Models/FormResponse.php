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
        return $this->belongsTo(ResponseViewUrl::class, 'uri','uri');
    }

    public function form()
    {
        return $this->belongsTo(Form::class,'form_id','id');
    }



    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('id_card')
            ->useFallbackUrl('/images/NCUA_official_seal.svg.png')
            ->acceptsMimeTypes(['application/pdf','image/jpg','image/png','image/JPEG','image/jpeg']);
        $this
            ->addMediaCollection('selfi_id_card')
            ->useFallbackUrl('/images/NCUA_official_seal.svg.png')
            ->acceptsMimeTypes(['application/pdf','image/jpg','image/png','image/JPEG','image/jpeg']);
    }
}
