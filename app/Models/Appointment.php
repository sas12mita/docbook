<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;


    // Define the table associated with the model (optional if follows conventions)
    protected $table = 'appointments';
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'appointment_date',
        'start_time',
        'end_time',
    ];


    // Define relationships
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}

