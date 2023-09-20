<?php

namespace App\Models\Gallery;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class GalleryFile extends Model
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'gallery_files';

    /**
     * {@inheritdoc}
     */
    protected $fillable = ['alt', 'description', 'basename', 'path'];

    /**
     * {@inheritdoc}
     */
    protected $appends = ['src'];

    /**
     * {@inheritdoc}
     */
    protected $visible = ['src', 'alt', 'description', 'path'];

    public function gallery(): BelongsTo
    {
        return $this->belongsTo(Gallery::class, 'gallery_id');
    }

    public function getSrcAttribute(): string
    {
        return Storage::url($this->path);
    }
}
