<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteTmplvarContentvalue extends Model
{
    use HasFactory;

    protected $table = 'site_tmplvar_contentvalues';

    protected $casts = [
        'tmplvarid' => 'int',
        'contentid' => 'int',
    ];

    protected $fillable = ['tmplvarid', 'contentid', 'value'];

    public function resource()
    {
        return $this->belongsTo(SiteContent::class, 'contentid', 'id');
    }

    public function tmplvar()
    {
        return $this->belongsTo(SiteTmplvar::class, 'tmplvarid', 'id');
    }
}
