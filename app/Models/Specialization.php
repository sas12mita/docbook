<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Doctor;

class Specialization extends Model
{
    protected $guarded=[];
    public function doctor()
    {
        return $this->hasMany(Doctor::class);
    }
    public function patient()
    {
        return $this->belongsTo(patient::class);
    }
}
