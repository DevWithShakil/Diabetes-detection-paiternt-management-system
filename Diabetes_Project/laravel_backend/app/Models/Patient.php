<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
         'user_id','name','age','glucose','blood_pressure','skin_thickness',
        'insulin','bmi','diabetes_pedigree','result'
    ];

    protected $casts = [
        'result' => 'array',
    ];

    public function appointments(){ return $this->hasMany(Appointment::class); }
    public function user()
{
    return $this->belongsTo(User::class);
}

}
