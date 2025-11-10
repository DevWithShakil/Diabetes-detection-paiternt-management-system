<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'glucose',
        'blood_pressure',
        'skin_thickness',
        'insulin',
        'bmi',
        'diabetes_pedigree',
        'result',
    ];
}
