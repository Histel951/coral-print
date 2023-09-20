<?php

namespace App\Services\Calculator;

enum CalculatorType: string
{
    case BusinessCards = 'businessCards';
    case Stickers = 'stickers';
    case Catalogs = 'catalogs';
    case Booklets = 'booklets';
    case Labels = 'labels';
    case labelsTag = 'labelsTag';
}
