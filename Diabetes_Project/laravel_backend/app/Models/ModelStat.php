<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ModelStat extends Model {
    protected $fillable = ['model_name','accuracy','runs'];
}
