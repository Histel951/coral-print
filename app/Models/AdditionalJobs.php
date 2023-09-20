<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdditionalJobs extends Model
{
    use HasFactory;

    protected $table = 'coral_additional_jobs';

    protected $fillable = ['name', 'alias'];
}
