<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model {
    protected $fillable = ['name','specialization','phone','chamber_location'];
    public function appointments(){ return $this->hasMany(Appointment::class); }
}
