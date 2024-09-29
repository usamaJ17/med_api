<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Tweek extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $table = 'tweek';
    protected $fillable=[
        'type','value'
    ];
    public function getAllMedia()
    {
        $mediaItems = $this->getMedia(); // Retrieve all media items
        return $mediaItems;
        $media = [];
        foreach($mediaItems as $item){
            $media[] = $item->getFullUrl();
        }
        return $media;
    }
}
