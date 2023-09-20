<?php

namespace App\Models;

use App\Models\Gallery\Gallery;
use App\Models\Gallery\GalleryFile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FileUpload extends Model
{
    use HasFactory;

    protected $guarded = false;

    public function gallery(): BelongsToMany
    {
        return $this->belongsToMany(Gallery::class)->using(GalleryFile::class);
    }
}
