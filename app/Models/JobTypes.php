<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JobTypes extends Model
{
    use HasFactory;

    protected $table = 'coral_job_types';

    protected $fillable = ['name', 'alias', 'code', 'job_id', 'formula_id', 'weight', 'volume', 'color'];

    public function job(): HasOne
    {
        return $this->hasOne(AdditionalJobs::class, 'id', 'job_id');
    }

    public function prices(): HasMany
    {
        return $this->hasMany(JobPrices::class, 'job_type_id', 'id');
    }

    public function formula(): HasOne
    {
        return $this->hasOne(Formulas::class, 'id', 'formula_id');
    }
}
