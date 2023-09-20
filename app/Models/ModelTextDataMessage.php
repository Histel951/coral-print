<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Symfony\Component\ErrorHandler\Error\ClassNotFoundError;

class ModelTextDataMessage extends Model
{
    use HasFactory;

    protected $fillable = ['model_class', 'message'];

    public function calculator(): BelongsToMany
    {
        return $this->belongsToMany(Calculator::class)->using(CalculatorModelTextDataMessage::class);
    }

    /**
     * Перед записью проверяет существует ли текущий класс модели
     * @return Attribute
     */
    protected function modelClass(): Attribute
    {
        return Attribute::make(
            set: function (string $modelClass) {
                if (class_exists($modelClass)) {
                    return $modelClass;
                }

                throw new ClassNotFoundError("Class ${$modelClass} is not found.");
            },
        );
    }
}
